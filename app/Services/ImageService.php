<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;

class ImageService
{
        /**
     * Upload an image and save it to the database
     *
     * @param UploadedFile $file
     * @param string $type (profile, post, gallery)
     * @param string|null $alt
     * @return Image
     */
    public function upload(UploadedFile $file, string $type, ?string $alt = null): Image
    {
        $path = $file->store("images/{$type}", 'public');

        return Image::create([
            'image' => $path,
            'type' => $type,
            'alt' => $alt,
        ]);
    }
}
