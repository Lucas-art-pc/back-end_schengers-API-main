<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterStudentRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterStudentController extends Controller
{

    public function __invoke(RegisterStudentRequest $request)
    {
        try {
            $data = $request->validated();


            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'date_of_birthday' => $data['date_of_birthday'],
                'term_privacy' => $data['term_privacy'],
                'password' => Hash::make($data['password']),
            ]);

            return response()->json([
                'message' => 'Usuário cadastrado com sucesso',
                'user' => new UserResource($user)
            ], 201);

        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Erro ao cadastrar usuário',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
