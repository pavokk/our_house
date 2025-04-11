<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;

class ImageController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService) {
        $this->imageService = $imageService;
    }

    public function uploadProfilePicture(Request $request) {
        $request->validate([
            'file' => 'required|image|mimes:png,jpg,jpeg,gif,webp|max:2048',
        ]);

        $user = auth()->user();

        $image = $this->imageService->upload(
            $request->file('file'),
            'profile',
            $user->name . 's profilbilde',
        );

        return $image;
    }
}
