<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
// use Laravel\Socialite\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;


class GoogleController extends Controller
{
    //
    public function redirectToGoogle()
{
    return Socialite::driver('google')->redirect();
}
public function handleGoogleCallback()
{
    $googleUser = Socialite::driver('google')->stateless()->user();

    $user = User::where('email', $googleUser->getEmail())->first();

    if ($user) {

        // 🔥 If existing user but google_id is null, update it
        if ($user->google_id == null) {
            $user->update([
                'google_id' => $googleUser->getId()
            ]);
        }

        Auth::login($user);

        if ($user->role == 1) {
            return redirect('admin/home');
        }

        return redirect('/');
    }

    // 🔵 If user not exists → create new
    $user = User::create([
        'google_id' => $googleUser->getId(),
        'name' => $googleUser->getName(),
        'email' => $googleUser->getEmail(),
        'password' => bcrypt(Str::random(16)),
        'role' => 2,
    ]);
     Auth::login($user);
    return redirect('register');
}
}
