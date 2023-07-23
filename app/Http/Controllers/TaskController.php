<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TaskController extends Controller
{
    public function index()
    {
        return response()->json(Task::orderBy('id', 'DESC')->get());
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:pending,in-progress,completed',
        ]);

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()], 400);

        $task = Task::create($request->all());
        return response()->json(['message' => 'Task has been created successfully.', 'data' => $task]);
    }

    public function show($id)
    {
        $task = Task::find($id);
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:pending,in-progress,completed',
        ]);

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()], 400);

        $task = Task::find($id);
        if($task)
        {
            $task->update($request->all());
            return response()->json(['message' => 'Task has been updated successfully.']);
        }
        return response()->json(['error' => 'Sorry! Unable to find the task.'],404);
    }

    public function delete($id)
    {
        $task = Task::find($id);
        if($task)
        {
            $task->delete();
            return response()->json(['message' => 'Task has been deleted successfully.']);
        }

        return response()->json(['error' => 'Sorry! Unable to find the task.'],404);
    }
}
