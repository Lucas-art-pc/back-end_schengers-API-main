<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserEditData extends Controller
{
    //

    public function editPassword(EditPassword $request)
    {
        $user = $request->user();

        // Verifica se a senha atual está correta
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'A senha atual está incorreta.'
            ], 422);
        }

        // Atualiza para a nova senha
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'message' => 'Senha alterada com sucesso.'
        ], 200);
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'url_image_profile' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'url_image_profile.max' => 'Imagem muito grande. O tamanho máximo permitido é 2MB.',
            'url_image_profile.uploaded' => 'Imagem muito grande. O tamanho máximo permitido é 2MB.',
            'url_image_profile.image' => 'O arquivo enviado precisa ser uma imagem.',
            'url_image_profile.mimes' => 'Formato inválido. Use JPEG, PNG, JPG ou WEBP.',
            'url_image_profile.required' => 'Você precisa selecionar uma imagem.',
        ]);

        $user = $request->user();

        // Remove imagem antiga
        if ($user->url_image_profile) {
            \Storage::disk('public')->delete($user->url_image_profile);
        }

        $path = $request->file('url_image_profile')->store('avatars', 'public');

        $user->update(['url_image_profile' => $path]);

        return response()->json([
            'message' => 'Avatar atualizado com sucesso.',
            'avatar_url' => asset('storage/' . $path),
        ]);
    }
}
