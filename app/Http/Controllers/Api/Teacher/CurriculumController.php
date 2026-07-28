<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurriculumRequest;
use App\Http\Resources\CurriculumResource;

use App\Http\Resources\VacancyCurriculum;
use App\Models\Curriculum;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{

    private function resolveDocument(CurriculumRequest $request, string $field): ?string
    {
        return $request->hasFile($field)
            ? $request->file($field)->store('curriculums', 'public')
            : $request->input($field);
    }


    public function indexByVacancy(string $public_id)
    {
        $vacancy = Vacancy::where('public_id', $public_id)
            ->with(['curriculums' => function ($query) {
                $query->where('status', '!=', 'approved')->with('teacher');
            }])
            ->firstOrFail();

        return response()->json(new VacancyCurriculum($vacancy));
    }


    public function show(string $public_id)
    {
        $curriculum = Curriculum::where('public_id', $public_id)
            ->with(['vacancy', 'teacher'])
            ->firstOrFail();

        if (!$curriculum) {
            return response()->json([
                'error' => 'Currículo não encontrado.',
            ], 404);
        }

        return response()->json( new CurriculumResource($curriculum));
    }


    public function store(CurriculumRequest $request, string $public_id)
{
    $vacancy = Vacancy::where('public_id', $public_id)
        ->select('id_vacancy')
        ->firstOrFail();

    $curriculum = Curriculum::create([
        ...$request->validated(),
        'fk_id_teacher' => auth()->id(),
        'fk_id_vacancy' => $vacancy->id_vacancy,
        'status' => 'pending',
        'personal_document' => $this->resolveDocument($request, 'personal_document'),
        'professional_document' => $this->resolveDocument($request, 'professional_document'),
    ]);

    return response()->json([
        'message' => 'Currículo enviado com sucesso!',
        'data'    => $curriculum,
    ], 201);
}
}
