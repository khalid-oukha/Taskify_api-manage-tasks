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
        $user = Auth::user();
        return new TaskCollection($user->task->paginate(10));
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

    public function store(StoreTaskRequest $request)
    {
        $user = Auth::user();
        $task = $user->task->create($request->validated());

        return new TaskResource($task);
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

    public function show(Task $task)
    {
        $user = Auth::user();
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

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $user = Auth::user();
        if ($user->id !== $task->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task->update($request->validated());
        return new TaskResource($task);
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

    public function destroy(Task $task)
    {
        $user = Auth::user();
        if ($user->id !== $task->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
}
