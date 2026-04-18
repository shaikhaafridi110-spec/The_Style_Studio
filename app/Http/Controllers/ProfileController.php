<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the user profile page.
     */
    public function index()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Update personal info + address.
     * Email is NOT changeable here — it is hidden/read-only in the view.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'phone'         => ['nullable', 'string', 'max:20'],
            'address_line1' => ['nullable', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city'          => ['nullable', 'string', 'max:100'],
            'state'         => ['nullable', 'string', 'max:100'],
            'postal_code'   => ['nullable', 'string', 'max:20'],
            'birthdate'     => ['nullable', 'date', 'before:today'],
            'gender'        => ['nullable', 'in:male,female,other'],
        ]);

        $user->update($request->only([
            'name', 'phone',
            'address_line1', 'address_line2',
            'city', 'state', 'postal_code',
            'birthdate', 'gender',
        ]));

        return redirect()->route('profile.index')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Update password.
     * Wrong current password → redirect straight to forgot-password page.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        // ── Plain-text comparison (consistent with rest of this app) ──
        if ($user->password !== $request->current_password) {
            return redirect('forgot-password')
                ->with('info', 'Current password is incorrect. Reset your password below.');
        }

        $user->update(['password' => $request->password]);

        return redirect()->route('profile.index')
            ->with('success', 'Password updated successfully.');
    }
}