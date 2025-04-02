<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    private function uploadImage($file, $type, $alt = null) {
        $path = $file->store("images/{$type}", 'public');

        return Image::create([
            'image' => $path,
            'type' => $type,
            'alt' => $alt,
        ]);
    }

    public function uploadProfilePicture(Request $request) {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ]);

        $user = auth()->user();

        $image = $this->uploadImage(
            $request->file('profile_picture'), 
            'profile', 
            $user->name . "s profilbilde"
        );
    }
}
