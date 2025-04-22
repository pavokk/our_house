<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Image;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = Image::all();
        return view("gallery.index", compact("images"));
    }

}
