<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'O email não existe!'
            ]);
        }

        $plainToken = Str::random(64);

        DB::table('tb_password_resets')->where('email', $request->email)->delete();

        DB::table('tb_password_resets')->insert([
            'email' => $request->email,
            'token' => Hash::make($plainToken),
            'created_at' => now(),
            'expires_at' => now()->addMinutes(60)
        ]);

        $resetLink = config('app.frontend_url') . "/auth/reset-password?token={$plainToken}&email={$request->email}";

        Mail::to($request->email)->queue(new ResetPasswordMail($resetLink));
        return response()->json([
            'message' => 'Se o email existir, você receberá instruções.'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'                 => 'required|email',
            'token'                 => 'required|string',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $record = DB::table('tb_password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return response()->json([
                'message' => 'Token inválido ou expirado.'
            ], 400);
        }

        if (Carbon::parse($record->expires_at)->isPast()) {
            DB::table('tb_password_resets')->where('email', $request->email)->delete();

            return response()->json([
                'message' => 'Token expirado. Solicite uma nova recuperação de senha.'
            ], 400);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        if (Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'A nova senha não pode ser igual à senha atual.'
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('tb_password_resets')->where('email', $request->email)->delete();

        return response()->json([
            'message' => 'Senha redefinida com sucesso.'
        ]);
    }
}
