<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\HomeContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $homeContent = HomeContent::where('id', 1)->first();
        return view('auth.login', compact('homeContent'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect berdasarkan role
        if ($user->hasRole(['admin', 'super_admin'])) {
            session(['show_role_modal' => true]);
        } elseif ($user->hasRole('calonSiswa')) {
            return redirect()->intended('/penerimaan');
        } elseif ($user->hasRole('pengunjung')) {
            return redirect()->intended('/');
        }

        // Fallback kalau tidak punya role sama sekali
        return redirect()->intended('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
