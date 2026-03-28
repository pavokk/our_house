<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class TaskController extends Controller
{
    public function wheelIndex()
    {
        $wheelTasks = Task::with(['user', 'assignee'])->where('status', TaskStatus::TODO)->get();
        $allTasks   = Task::with(['user', 'assignee'])->orderBy('status')->get();
        return view("wheel.index", compact('wheelTasks', 'allTasks'));
    }

    public function myTasks()
    {
        $tasks = Task::with(['user'])
            ->where('assignee_id', Auth::id())
            ->orderBy('status')
            ->get();
        return view('wheel.my-tasks', compact('tasks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        Task::create([
            ...$validated,
            'slug'    => Str::slug($validated['title']),
            'user_id' => Auth::id(),
            'status'  => TaskStatus::TODO,
        ]);

        return redirect()->route('wheel.index');
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $task->update($validated);

        return redirect()->route('wheel.index');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $data = ['status' => $validated['status']];

        if ($request->boolean('clear_assignee')) {
            $data['assignee_id'] = null;
        }

        $task->update($data);

        return redirect()->route('wheel.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('wheel.index');
    }

    public function assignTask(Request $request, Task $task)
    {
        $task->update([
            'assignee_id' => Auth::id(),
            'status'      => TaskStatus::IN_PROGRESS,
        ]);

        return response()->json([
            'success'  => true,
            'assignee' => Auth::user()->name,
        ]);
    }
}
