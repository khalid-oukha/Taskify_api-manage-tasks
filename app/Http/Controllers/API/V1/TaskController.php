<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\V1\TaskCollection;
use App\Http\Resources\V1\TaskResource;
use App\Models\Task;

/**
 * @OA\Tag(
 *     name="Tasks",
 *     description="Operations related to tasks"
 * )
 */
class TaskController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/v1/task",
     *     summary="List all tasks",
     *     tags={"Tasks"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="A list of tasks",
     *         )
     *     ),
     *     @OA\Response(response="404", description="No tasks found")
     * )
     */
    public function index()
    {
        //
        return new TaskCollection(Task::paginate());
    }


    /**
     * @OA\Post(
     *     path="/api/v1/task",
     *     summary="Create a new task",
     *     tags={"Tasks"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data for creating a new task"
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Task created successfully"
     *     ),
     *     @OA\Response(response="400", description="Bad request"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */

    public function store(StoreTaskRequest $request)
    {
        //        
        $task = Task::create($request->validated());
    }

    /**
     * @OA\Get(
     *     path="/api/v1/task/{taskId}",
     *     summary="Get details of a specific task",
     *     tags={"Tasks"},
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
     *         description="Task details"
     *     ),
     *     @OA\Response(response="404", description="Task not found")
     * )
     */

    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/task/{taskId}",
     *     summary="Update a specific task",
     *     tags={"Tasks"},
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
     *         description="Data for updating the task"
     *     ),
     *     @OA\Response(response="200", description="Task updated successfully"),
     *     @OA\Response(response="404", description="Task not found"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task = Task::findOrFail($task->id);
        $task->update($request->validated());
        return response()->json([
            "message" => "success",
            "message" => "task updated successfully",
            "task" => $task,
        ]);
    }

    /**
 * @OA\Delete(
 *     path="/api/v1/task/{taskId}",
 *     summary="Delete a specific task",
 *     tags={"Tasks"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="taskId",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID of the task to delete"
 *     ),
 *     @OA\Response(response="200", description="Task deleted successfully"),
 *     @OA\Response(response="404", description="Task not found")
 * )
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
