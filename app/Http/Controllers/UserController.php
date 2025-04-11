<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Services\ImageService;


class UserController extends Controller
{

    public function show (User $user) {
        return view('user.show', compact('user'));
    }

    public function edit () {

        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    public function updateDetails(Request $request) {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email' . auth()->id(),
            'description' => 'nullable|string|max:512',
        ]);

        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function changeProfilePicture(Request $request) {

        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10000',
        ]);

        $user = auth()->user();

        $imageService = new ImageService();

        $image = $imageService->upload(
            $request->file('file'),
            'profile',
            $user->name . 's profilbilde',
        );

        $user->image_id = $image->id;
        $user->save();

        return back()->with('success', 'Profile picture updated successfully.');

    }

    public function updatePassword (Request $request) {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|min:8|confirmed',
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully.');
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
        $user->slug = Str::slug($user->name);
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        Auth::login($user);
        return redirect()->route('index')->with('success', 'Registering fullført.');
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

    public function confirmDelete() {
        return view('user.confirm-delete');
    }

    public function destroy(Request $request) {
        $user = auth()->user();
        $user->delete();

        auth()->logout();

        return redirect('/')->with('success', 'Account deleted successfully.');
    }
}
