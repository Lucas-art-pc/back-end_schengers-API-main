<?php

namespace App\Http\Controllers\Api\Course\ActivityCourse;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityCourseRequest;
use App\Models\ActivityCourse;
use App\Models\AlternativeActivityCourse;
use App\Models\Course;
use App\Models\StudentAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;


class ActivityCourseController extends Controller
{
    //

    public function index(string $public_id)
    {
        $course = Course::with([
            'activities.alternatives'
        ])
            ->where('public_id', $public_id)
            ->first();

        if (!$course) {
            return response()->json([
                'message' => 'Curso não encontrado.',
                'status' => 404,
            ], 404);
        }

        return response()->json([
            'activities' => $course->activities,
            'status' => 200
        ]);
    }

    public function store(ActivityCourseRequest $request, string $public_id)
    {
        $course = Course::where('public_id', $public_id)->firstOrFail();

        try {
            $activity = DB::transaction(function () use ($request, $course) {

                $activity = ActivityCourse::create([
                    'title_activity'       => $request->title_activity,
                    'description_activity' => $request->description_activity,
                    'question_activity'    => $request->question_activity,   // ✅ corrigido
                    'fk_id_course'         => $course->id_course,
                ]);


                foreach ($request->alternatives as $alternative) {
                    $activity->alternatives()->create([
                        'title_alternative'   => $alternative['title_alternative'],
                        'text_alternative'    => $alternative['text_alternative'],
                        'correct_alternative' => $alternative['correct_alternative'],
                    ]);
                }

                return $activity;
            });

            return response()->json([
                'message' => 'Atividade criada com sucesso.',
                'data'    => $activity->load('alternatives'),
            ], 201);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Erro ao criar a atividade. Tente novamente.',
            ], 500);
        }
    }

    public function show(Request $request, string $public_id, string $id_activity)
    {
        $user = $request->user();

        $course = Course::where('public_id', $public_id)->firstOrFail();

        $activity = ActivityCourse::where('fk_id_course', $course->id_course)
            ->where('public_id', $id_activity)
            ->firstOrFail();

        $alternatives = AlternativeActivityCourse::where(
            'fk_id_activity',
            $activity->id_activity
        )->get();

        $answer = StudentAnswer::where('fk_id_student', $user->id)
            ->where('fk_id_activity', $activity->id_activity)
            ->first();

        return response()->json([
            'activity' => $activity,
            'alternatives' => $alternatives,
            'answer' => $answer
        ]);
    }


    public function update(ActivityCourseRequest $request, string $public_id, string $public_id_activity)
    {
        $course   = Course::where('public_id', $public_id)->firstOrFail();
        $activity = ActivityCourse::where('public_id', $public_id_activity)  // ✅
        ->where('fk_id_course', $course->id_course)
            ->firstOrFail();

        try {
            DB::transaction(function () use ($request, $activity) {
                $activity->update([
                    'title_activity'       => $request->title_activity,
                    'description_activity' => $request->description_activity,
                    'question_activity'    => $request->question_activity,
                ]);

                foreach ($request->alternatives as $alt) {
                    $activity->alternatives()->updateOrCreate(
                        ['id_alternative' => $alt['id_alternative'] ?? null],
                        [
                            'title_alternative'   => $alt['title_alternative'],
                            'text_alternative'    => $alt['text_alternative'],
                            'correct_alternative' => $alt['correct_alternative'],
                        ]
                    );
                }

                $incomingIds = collect($request->alternatives)
                    ->pluck('id_alternative')
                    ->filter()
                    ->values();

                $activity->alternatives()
                    ->whereNotIn('id_alternative', $incomingIds)
                    ->delete();
            });

            return response()->json([
                'message' => 'Atividade atualizada com sucesso.',
                'data'    => $activity->load('alternatives'),
            ]);

        } catch (Throwable $e) {
            report($e);
            return response()->json(['message' => 'Erro ao atualizar a atividade.'], 500);
        }
    }

    public function destroy(string $public_id, string $public_id_activity){
        $course = Course::where('public_id', $public_id)
            ->firstOrFail();

        $activity = ActivityCourse::where('fk_id_course', $course->id_course)
            ->where('public_id', $public_id_activity)
            ->firstOrFail();

        $activity->delete();

        return response()->json([
            'message' => 'Atividade apagada com sucesso.',
            'code' => 200
        ]);
    }

}
