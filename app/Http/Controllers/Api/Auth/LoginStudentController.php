<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginStudentController extends Controller
{

    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->validated();

        $key = Str::lower($credentials['email']).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            return response()->json([
                'message' => "Muitas tentativas de login incorretas. Tente novamente em " . ceil($seconds / 60) . " minuto(s).",
                'retry_after' => $seconds,
            ], 429);
        }

        if (!Auth::guard('web')->attempt($credentials)) {
            RateLimiter::hit($key, 60 * 60 * 2);

            return response()->json([
                'message' => 'Credenciais inválidas.',
                'tentativas_restantes' => max(0, 5 - RateLimiter::attempts($key)),
            ], 401);
        }

        RateLimiter::clear($key);

        $student = Auth::guard('web')->user();

        $token = $student->createToken('auth_token_user')->plainTextToken;

        return response()->json([
            'message' => 'Login realizado com sucesso.',
            'auth_token_user' => $token,
            'status' => 200
        ], 200);
    }

}
