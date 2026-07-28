<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Mail\SendEmailTeacherApproved;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class ActionCurriculumController extends Controller
{
    //



    public function approveCurriculum(Curriculum $curriculum)
    {
        DB::transaction(function () use ($curriculum) {

            $curriculum->update([
                'status' => 'approved'
            ]);

            if ($curriculum->teacher) {
                $curriculum->teacher->update([
                    'status' => 'approved'
                ]);
            }

            // Dispara APÓS commit
            DB::afterCommit(function () use ($curriculum) {

                if ($curriculum->teacher && $curriculum->email) {
                    Mail::to($curriculum->email)
                        ->queue(new SendEmailTeacherApproved($curriculum));
                }

            });
        });

        return response()->json([
            'message' => 'Currículo aprovado e e-mail enviado com sucesso!'
        ]);
    }



    public function rejectCurriculum(Curriculum $curriculum)
    {
        $curriculum->update([
            'status' => 'rejected'
        ]);

        if ($curriculum->teacher) {
            $curriculum->teacher->update([
                'status' => 'rejected'
            ]);
        }

        return response()->json([
            'message' => 'Currículo não aceito com sucesso.'
        ]);
    }

}
