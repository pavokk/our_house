<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;

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
        $request->validate([]);

        $event = new Event();
    }

}
