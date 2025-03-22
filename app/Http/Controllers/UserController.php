<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    public function show (User $user) {
        return view('user.show', compact('user'));
    }

    public function edit () {
        return view('user.edit');
    }

    public function showRegisterForm() {
        $title = 'Registrer deg - Skagesundvegen 63';
        return view('user.register', compact('title'));
    }

    public function register (Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'image' => 'nullable|image|max:10240',
            'description' => 'nullable|string|max:5000',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        Auth::login($user);
        return redirect()->route('index')->with('success', 'Registering fullført.');
    }

    public function update(Request $request) {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'image' => 'nullable|image|max:10240',
            'description' => 'nullable|string|max:5000',
        ]);

        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request-hasFile('image')) {
            $path = $request->file('image')->store('images/profile-pictures', 'public');
            $user->image = $path;
        }

        if ($request->filled('description')) {
            $user->description = $request->description;
        }

        return redirect()->route('user.show')->with('success', 'Profil endret.');
    }

    public function showLoginForm() {
        $title = 'Logg inn - Skagesundvegen 63';
        return view('user.login', compact('title'));
    }

    public function login (Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('index')->with('success', 'Logget inn.');
        }

        return back()->withErrors(['email' => 'Feil e-post eller passord'])->withInput();
    }

    public function logout (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index')->with('success', 'Du er nå logget ut.');
    }
}
