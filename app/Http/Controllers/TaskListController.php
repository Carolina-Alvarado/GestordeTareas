<?php

namespace App\Http\Controllers;

use App\Models\TaskList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskListController extends Controller
{
    public function index(Request $request)
    {
        $tasks = TaskList::where('user_id', $request->user()->id)->get();
        dd($tasks); 
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'prioridad' => 'required|in:baja,media,alta',
            'fecha_vencimiento' => 'nullable|date',
        ]);

        return TaskList::create($request->all());
    }

    public function show(TaskList $taskList)
    {
        return $taskList;
    }

    public function update(Request $request, TaskList $taskList)
    {
        $taskList->update($request->all());
        $taskList->update($request->only(['titulo', 'descripcion', 'prioridad', 'estado']));
        return $taskList;
    }

    public function destroy(TaskList $taskList)
    {
        $taskList->delete();
        return response()->json(['message' => 'Tarea eliminada']);
    }
}
