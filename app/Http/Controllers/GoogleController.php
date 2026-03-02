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

    $existingUser = User::where('email', $googleUser->getEmail())->first();

    // 🔴 If email already exists → show error on login page
    if ($existingUser) {
        return redirect('/login')->with('error', 'Email already exists. Please login manually.');
    }

    // 🟢 If new user → create account
    $user = User::create([
        'google_id' => $googleUser->getId(),
        'name' => $googleUser->getName(),
        'email' => $googleUser->getEmail(),
        'password' => bcrypt(Str::random(16)),
        'role' => 2,
    ]);

    Auth::login($user);

    return redirect('cprofile'); // or complete-profile
}
}
