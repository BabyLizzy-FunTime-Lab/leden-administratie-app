<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Toont de inlog pagina.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Verwerkt de loginlogica
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
           'name' => 'required|string|max:255',
           'password' => 'required|string',
        ]);

        if(Auth::attempt($validated)){
            $request->session()->regenerate();

            return match (Auth::user()->accessLevel?->name) {
                'admin' => redirect()->route('family.index'),
                'familie admin' => redirect()->route('family.index'),
                'familie lid' => redirect()->route('family.index'),
                default => redirect()->route('show.login'),
            };
        }

        throw ValidationException::withMessages([
            'credentials' => 'These credentials do not match our records.',
        ]);

    }

    /**
     * Verwerkt de logoutlogica
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // This only removes user data, but all other data will remain. So shopping cart stuff saved in the session
        // will persist.
        Auth::logout();
        // This will remove the rest of the data.
        $request->session()->invalidate();
        // This will replace the old token.
        $request->session()->regenerateToken();

        return redirect()->route('show.login');
    }
}
