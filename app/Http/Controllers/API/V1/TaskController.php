<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\V1\TaskCollection;
use App\Http\Resources\V1\TaskResource;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        //
        return new TaskCollection(Task::paginate());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        //        
        $task = Task::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task = Task::findOrFail($task->id);
        $task->update($request->validated());
        return response()->json([
            "message"=> "success",
            "message"=> "task updated successfully",
            "task" => $task,
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if ($task) {
            $task->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Task deleted successfully',
                'task' => new TaskResource($task),
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Task not found!',
        ], 404);
    }
}
