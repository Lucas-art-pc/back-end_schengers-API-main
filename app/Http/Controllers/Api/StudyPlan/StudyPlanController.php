<?php

namespace App\Http\Controllers\Api\StudyPlan;

use App\Http\Controllers\Controller;
use App\Models\StudyPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudyPlanController extends Controller
{
    //
    public function index()
    {

        $studyPlan = StudyPlan::where('fk_id_student', auth()->id())->get();

        return response()->json([
            'plans' => $studyPlan,
            'status' => 200
        ]);
    }

    public function store(Request $request)
    {
        $plan = StudyPlan::create([
            'fk_id_student' => auth()->id(),
            'day_of_week_study_plan' => $request->day_of_week_study_plan,
            'activity_study_plan' => $request->activity_study_plan,
            'description_study_plan' => $request->description_study_plan,
            'duration_study_plan' => $request->duration_study_plan,
        ]);

        return response()->json([
            'plans' => $plan,
            'status' => 200
        ]);
    }

    public function update(Request $request, $id)
    {
        $plan = StudyPlan::where('id', $id)
            ->where('fk_id_student', auth()->id())
            ->firstOrFail();

        $plan->update([
            'activity_study_plan' => $request->activity_study_plan ?? $plan->activity_study_plan,
            'day_of_week_study_plan' => $request->day_of_week_study_plan ?? $plan->day_of_week_study_plan,
            'description_study_plan' => $request->description_study_plan ?? $plan->description_study_plan,
            'duration_study_plan' => $request->duration_study_plan ?? $plan->duration_study_plan,
        ]);

        return response()->json([
            'message' => 'Plano atualizado com sucesso',
            'data' => $plan
        ]);
    }

    public function destroy($id)
    {
        StudyPlan::destroy($id);
        return response()->json([
            'message' => 'Plano excluído com sucesso',
            'status' => 200
            ]
        );
    }
}
