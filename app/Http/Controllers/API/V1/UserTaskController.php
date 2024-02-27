<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\V1\TaskCollection;
use App\Http\Resources\V1\TaskResource;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class UserTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        //
        $user = Auth::user();
        dd($user);
        return new TaskCollection($user->task->paginate(10));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $user = Auth::user();
        $task = $user->task->create($request->validated());

        return new TaskResource($task);
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
        $task->update($request->validated());
        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
}
