<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Un lien de réinitialisation du mot de passe a été envoyé à votre adresse email.'])
            : response()->json(['message' => 'Une erreur est survenue lors de l\'envoi du lien de réinitialisation.'], 500);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => 'Votre mot de passe a été réinitialisé avec succès.'])
            : response()->json(['message' => 'Une erreur est survenue lors de la réinitialisation du mot de passe.'], 500);
    }

    public function checkResetToken(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
        ]);

        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset) {
            return response()->json(['message' => 'Votre lien de réinitialisation est invalide ou a expiré.'], 422);
        }

        if (!Hash::check($request->token, $passwordReset->token)) {
            return response()->json(['message' => 'Votre lien de réinitialisation est invalide ou a expiré.'], 422);
        }

        if ($this->isTokenExpired($passwordReset->created_at)) {
            return response()->json(['message' => 'Votre lien de réinitialisation est invalide ou a expiré.'], 422);
        }

        return response()->json(['message' => 'Lien de réinitialisation valide.'], 200);
    }

    private function isTokenExpired($createdAt)
    {
        $expirationTime = Carbon::parse($createdAt)->addMinutes(config('auth.passwords.users.expire', 60));

        return $expirationTime->isPast();
    }
}
