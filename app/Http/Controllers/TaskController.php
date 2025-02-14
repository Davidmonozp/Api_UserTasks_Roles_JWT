<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function addTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 400);
        }

        $task = new Task([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'user_id' => auth()->id(),
        ]);

        $task->save();

        return response()->json([
            'message' => 'Tarea creada exitosamente.',
            'task' => $task
        ], 201);
    }

    public function getTasks()
    {
        $tasks = Task::all();
        if ($tasks->isEmpty()) {
            return response()->json(['message' => 'No hay tareas'], 404);
        }
        return response()->json($tasks, 200);
    }

    public function getTasksById($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Tarea no encontrada'], 404);
        }
        return response()->json($task, 200);
    }


    public function updateTaskById(Request $request, $id) {

        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Tarea no encontrada'], 404);
        }

        $user = auth()->user();

        if ($task->user_id !== $user->id && $user->role !== 'admin') {
            return response()->json(['message' => 'No autorizado para editar esta tarea'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        if ($request->has('title')) {
            $task->title = $request->input('title');
        }

        if ($request->has('description')) {
            $task->description = $request->input('description');
        }

        $task->save();

        return response()->json(['message' => 'Tarea actualizada correctamente', 'task' => $task], 200);
    }


    public function deleteTaskById($id) {
        // Buscar la tarea por ID
        $task = Task::find($id);

        // Verificar si la tarea existe
        if (!$task) {
            return response()->json(['message' => 'Tarea no encontrada'], 404);
        }

        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario es el propietario de la tarea o si es un administrador
        if ($task->user_id !== $user->id && $user->role !== 'admin') {
            return response()->json(['message' => 'No autorizado para eliminar esta tarea'], 403);
        }

        // Eliminar la tarea
        $task->delete();

        // Responder con el mensaje de éxito
        return response()->json(['message' => 'Tarea eliminada correctamente'], 200);
    }
}
