<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\V1\TaskCollection;
use App\Http\Resources\V1\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTaskController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/usertask",
     *     summary="List all tasks of the authenticated user",
     *     tags={"UserTasks"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="A list of tasks",
     *     ),
     *     @OA\Response(response="404", description="No tasks found"),
     *     @OA\Response(response="401", description="Unauthorized")
     * )
     */


    public function index()
    {
        $user = auth()->user();
        $tasks = TaskResource::collection($user->tasks);
        return response()->json(['data' => $tasks], 200);
    }



    /**
     * @OA\Post(
     *     path="/api/v1/usertask",
     *     summary="Create a new task for the authenticated user",
     *     tags={"UserTasks"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data for creating a new task",
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Task created successfully",
     *     ),
     *     @OA\Response(response="422", description="Validation error"),
     *     @OA\Response(response="401", description="Unauthorized")
     * )
     */

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            "name" => "required|string",
            "status" => ["required", "string", "in:to do,doing,done"],
        ]);
        $task = $request->user()->tasks()->create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        $task = new TaskResource($task);
        $tasks = $user->tasks;
        if ($task) {
            return response()->json([
                'status' => 'success',
                'message' => 'Task created successfully',
                // 'task' => $task,
                'tasks' => $tasks,

            ], 201);
        }

        return response()->json([
            'error' => 'error',
            'message' => 'Error withing creating the task',
        ], 400);
    }


    /**
     * @OA\Get(
     *     path="/api/v1/usertask/{taskId}",
     *     summary="Get details of a specific task of the authenticated user",
     *     tags={"UserTasks"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="taskId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the task to retrieve"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task details",
     *     ),
     *     @OA\Response(response="404", description="Task not found"),
     *     @OA\Response(response="403", description="Unauthorized")
     * )
     */

    public function show($id)
    {
        $user = Auth::user();
        $task = Task::findOrfail($id);
        if ($user->id !== $task->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return new TaskResource($task);
    }



    /**
     * @OA\Put(
     *     path="/api/v1/usertask/{taskId}",
     *     summary="Update a specific task of the authenticated user",
     *     tags={"UserTasks"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="taskId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the task to update"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data for updating the task",
     *     ),
     *     @OA\Response(response="200", description="Task updated successfully"),
     *     @OA\Response(response="404", description="Task not found"),
     *     @OA\Response(response="403", description="Unauthorized"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */

    public function update(UpdateTaskRequest $request, $id)
    {
        $user = Auth()->user();
        $task = Task::findOrfail($id);

        $this->authorize('update', $task);
        $task->update($request->validated());
        $tasks = $user->tasks;
        return response()->json([
            'status' => 'success',
            'message' => 'Task updated successfully',
            'tasks' => $tasks,
        ]);
    }


    /**
     * @OA\Delete(
     *     path="/api/v1/usertask/{taskId}",
     *     summary="Delete a specific task of the authenticated user",
     *     tags={"UserTasks"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="taskId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the task to delete"
     *     ),
     *     @OA\Response(response="200", description="Task deleted successfully"),
     *     @OA\Response(response="404", description="Task not found"),
     *     @OA\Response(response="403", description="Unauthorized")
     * )
     */

    public function destroy($id)
    {
        $this->authorize('delete', $task = Task::findOrfail($id));
        $user = Auth::user();
        $task = Task::findOrfail($id);
        if ($user->id !== $task->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task->delete();
        $tasks = $user->tasks;
        return response()->json([
            'tasks' => $tasks,
            'message' => 'Task deleted successfully'
        ]);
    }

    public function CompleteTask($id)
    {
        $user = Auth::user();
        $task = Task::findOrfail($id);
        if ($user->id !== $task->user_id) {
            return response()->json(['message'=> 'Unauthorized'], 403);
        }else{
            $task->update(['status' => 'done']);
            $tasks = $user->tasks;
            return response()->json([
                'tasks' => $tasks,
                'message'=> 'task done'], 200);

        }
    }
}
