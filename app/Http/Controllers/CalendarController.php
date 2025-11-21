<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\User;
use App\Services\ImageService;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        $users = User::all();
        return view("calendar.index", compact('events', 'users'));
    }

    public function show(Event $event)
    {
        $users = User::all()->keyBy('id')->toArray();
        return view('calendar.show', compact('event', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
        ]);

        $data = $validated;

        $data['slug'] = Str::slug($validated['title']);
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $imageService = new ImageService();
            $image = $imageService->upload(
                $request->file('image'),
                'posts',
                'Image uploaded by ' . Auth::user()->name,
            );
            $data['image_id'] = $image->id;
        }

        unset($data['image']);

        Event::create($data);

        return redirect()->route('calendar.index')->with('success', 'Event created!');
    }

}
