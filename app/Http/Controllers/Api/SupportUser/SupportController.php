<?php

namespace App\Http\Controllers\Api\SupportUser;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupportRequest;
use App\Http\Resources\SupportResource;
use App\Models\Support;


class SupportController extends Controller
{
    //

    public function supportsIndex()
    {
        $supports = Support::orderBy('status_support', 'desc')->with('student')->get();
        return response()->json(SupportResource::collection($supports));
    }

    public function supportByStudent()
    {
        $userId = auth()->id();
        $support = Support::where('fk_id_sender_user', $userId)->with('student')->get();
        return response()->json(SupportResource::collection($support));
    }

    public function store(SupportRequest $request)
    {
        $userId = auth()->id();

        $support = Support::create([
            ...$request->validated(),
            'fk_id_sender_user' => $userId,
            'status_support' => false,
        ]);

        return response()->json([
            'message' => 'Mensagem enviada com sucesso!',
            'support' => new SupportResource($support)
        ], 201);
    }

    public function show(string $public_id){

        if (!$public_id){
            return response()->json([
                'message' => 'Não foi encontrado nenhum registro!'
            ]);
        }

        $support = Support::where('public_id', $public_id)->with('student')->first();
        return response()->json(new SupportResource($support));
    }


    public function updateStatus(string $public_id)
    {
        $support = Support::where('public_id', $public_id)->first();

        if (!$support) {
            return response()->json(['message' => 'Registro não encontrado!'], 404);
        }

        $support->update(['status_support' => true]);

        return response()->json(['message' => 'Mensagem lida!']);
    }

    public function destroy(string $public_id)
    {
        $support = Support::where('public_id', $public_id)->first();

        if (!$support) {
            return response()->json(['message' => 'Registro não encontrado!'], 404);
        }

        $support->delete();

        return response()->json(['message' => 'Mensagem removida com sucesso!']);
    }
}
