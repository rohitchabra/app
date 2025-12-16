<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class LoginController extends Controller
{
    public function createTestUser()
    {
        User::create([
            'name' => 'Kunal Verma',
            'email' => 'Kunalverma.ce@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        return 'User created successfully!';
    }

    // Show login page
    public function create()
    {
        $roles = Role::all();

        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        // $user-> syncRoles($request->roles);

        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', 'Login successful!');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
