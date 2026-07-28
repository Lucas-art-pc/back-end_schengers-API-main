<?php

namespace App\Http\Controllers\Api\Course;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    //

    public function show(string $course_public_id)
    {
        $student = auth()->user();
        $course = Course::where('public_id', $course_public_id)->firstOrFail();

        // Verifica se o aluno está matriculado
        $enrolled = DB::table('tb_rel_student_course')
            ->where('fk_id_student', $student->id)
            ->where('fk_id_course', $course->id_course)
            ->exists();

        if (!$enrolled) {
            return response()->json([
                'message' => 'O usuário não está matriculado neste curso.',
                'status' => 403
            ]);
        }

        // Total de aulas do curso
        $totalLessons = DB::table('tb_class')
            ->where('fk_id_course', $course->id_course) // ajusta o nome da FK se necessário
            ->count();

        // Aulas concluídas pelo aluno
        $completedLessons = DB::table('tb_lesson_progress')
            ->join('tb_class', 'tb_lesson_progress.fk_id_class', '=', 'tb_class.id_class')
            ->where('tb_class.fk_id_course', $course->id_course) // ajusta o nome da FK se necessário
            ->where('tb_lesson_progress.fk_id_student', $student->id)
            ->where('tb_lesson_progress.is_completed', true)
            ->count();

        // Total de atividades do curso
        $totalActivities = DB::table('tb_activity')
            ->where('fk_id_course', $course->id_course) // ajusta o nome da FK se necessário
            ->count();

        // Atividades concluídas pelo aluno
        $completedActivities = DB::table('tb_student_answers')
            ->join('tb_activity', 'tb_student_answers.fk_id_activity', '=', 'tb_activity.id_activity')
            ->where('tb_activity.fk_id_course', $course->id_course) // ajusta o nome da FK se necessário
            ->where('tb_student_answers.fk_id_student', $student->id)
            ->count();



        // Verifica se concluiu tudo
        $finished = $totalLessons > 0
            && $totalActivities > 0
            && $completedLessons === $totalLessons
            && $completedActivities === $totalActivities;


        if (!$finished) {
            return response()->json([
                'message' => 'Curso ainda não concluído.',
                'status' => 403
            ]);
        }

        // Gera ou busca o certificado
        $certificate = Certificate::firstOrCreate(
            [
                'fk_id_student' => $student->id,
                'fk_id_course'  => $course->id_course,
            ],
            [
                'public_id' => Str::uuid(),
                'hash'      => Str::random(40),
                'issued_at' => now(),
            ]
        );

        return response()->json([

                'certificate_id' => $certificate->public_id,
                'hash'           => $certificate->hash,
                'issued_at'      => $certificate->issued_at,
                'workload'       => $course->duration_course,
                'student_name'   => $student->name,
                'course_title'   => $course->title_course,
                'validated_url'  => url("/api/certificates/validate/{$certificate->hash}"),

        ]);
    }

    public function validate(string $hash)
    {
        $certificate = Certificate::with(['student', 'course'])
            ->where('hash', $hash)
            ->firstOrFail();

        return response()->json([
            'data' => [
                'valid'        => true,
                'student_name' => $certificate->student->name_student,
                'course_title' => $certificate->course->title_course,
                'issued_at'    => $certificate->issued_at,
            ]
        ]);
    }
}
