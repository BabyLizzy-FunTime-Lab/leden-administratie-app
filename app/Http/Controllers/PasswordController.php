<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    /**
     * Kan een wachtwoord aanpassen (update) maar alleen voor de ingelogde user.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($validated['user_id']);

        // The user can only change his or her own password.
        if(Auth::user()->id == $user->id) {
            // Check the current password
            if (!Hash::check($validated['password'], $user->password)) {
                return back()->withErrors(['password' => 'Het huidige wachtwoord is onjuist.'])->withInput();
            }

            $user->update([
                'password' => Hash::make($validated['new_password'])
            ]);

            return redirect()->back()->with('success', 'Wachtwoord is succesvol bijgewerkt.');
        }

        return redirect()->back()->with('error', 'The user can only change his or her own password.');
    }
}
