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
    public function approveCurriculum(Curriculum $curriculum)
    {
        if ($curriculum->status === 'approved') {
            return response()->json(['message' => 'Currículo já aprovado.'], 409);
        }

        DB::transaction(function () use ($curriculum) {
            $curriculum->update(['status' => 'approved']);
            $curriculum->teacher?->update(['status' => 'approved']);
        });

        if ($curriculum->teacher && $curriculum->email) {
            Mail::to($curriculum->email)
                ->queue(new SendEmailTeacherApproved($curriculum->teacher));
        }

        return response()->json(['message' => 'Currículo aprovado com sucesso!']);
    }

    public function rejectCurriculum(Curriculum $curriculum)
    {
        DB::transaction(function () use ($curriculum) {
            $curriculum->update(['status' => 'rejected']);
            $curriculum->teacher?->update(['status' => 'rejected']);
        });

        return response()->json(['message' => 'Currículo não aceito com sucesso.']);
    }
}
