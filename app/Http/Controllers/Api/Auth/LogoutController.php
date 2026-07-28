<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    //

    public function __invoke(Request $request)
    {
        // Pega o usuário pelo token do Sanctum (funciona para qualquer guard)
        $user = $request->user() ?? $request->user('teacher');

        if (!$user) {
            return response()->json([
                'message' => 'Usuário não autenticado'
            ], 401);
        }

        // Revoga apenas o token atual, não todos
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso'
        ], 200);
    }
}
