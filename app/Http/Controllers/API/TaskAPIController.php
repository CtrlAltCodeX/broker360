<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTaskAPIRequest;
use App\Http\Requests\API\UpdateTaskAPIRequest;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class TaskAPIController
 */
class TaskAPIController extends AppBaseController
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepo)
    {
        $this->taskRepository = $taskRepo;
    }

    /**
     * Display a listing of the Tasks.
     * GET|HEAD /tasks
     */
    public function index(Request $request): JsonResponse
    {
        $tasks = $this->taskRepository->all(
            ["*"],
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse('Tasks retrieved successfully', $tasks->toArray());
    }

    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     operationId="storeTask",
     *     tags={"Tasks"},
     *     summary="Store a newly created Task",
     *     description="Store a newly created Task in storage",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"desc", "date", "time", "assigned_to", "category", "link"},
     *             @OA\Property(property="desc", type="string", example="Task description"),
     *             @OA\Property(property="date", type="string", format="date", example="2024-06-05"),
     *             @OA\Property(property="time", type="string", format="time", example="14:30:00"),
     *             @OA\Property(property="assigned_to", type="integer", example=1),
     *             @OA\Property(property="category", type="string", example="Work"),
     *             @OA\Property(property="link", type="string", format="url", example="http://example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task saved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Task"),
     *             @OA\Property(property="message", type="string", example="Task saved successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Bad Request")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Internal Server Error")
     *         )
     *     )
     * )
     * @OA\Schema(
     *     schema="Task",
     *     type="object",
     *     title="Task",
     *     description="Task model",
     *     properties={
     *         @OA\Property(property="id", type="integer", description="Task ID"),
     *         @OA\Property(property="name", type="string", description="Task name"),
     *         @OA\Property(property="description", type="string", description="Task description"),
     *         @OA\Property(property="status", type="string", description="Task status"),
     *         @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
     *         @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp")
     *     }
     * )
     */
    public function store(CreateTaskAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $task = $this->taskRepository->create($input);

        return $this->sendResponse('Task saved successfully', $task->toArray());
    }

    /**
     * Display the specified Task.
     *
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     operationId="getTaskById",
     *     tags={"Tasks"},
     *     summary="Get a task by ID",
     *     description="Returns a task with specified ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *         description="ID of the task to retrieve"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="desc",
     *                     type="string",
     *                     example="Task description"
     *                 ),
     *                 @OA\Property(
     *                     property="date",
     *                     type="string",
     *                     format="date",
     *                     example="2024-06-05"
     *                 ),
     *                 @OA\Property(
     *                     property="time",
     *                     type="string",
     *                     format="time",
     *                     example="14:00:00"
     *                 ),
     *                 @OA\Property(
     *                     property="assigned_to",
     *                     type="string",
     *                     example="John Doe"
     *                 ),
     *                 @OA\Property(
     *                     property="category",
     *                     type="string",
     *                     example="Development"
     *                 ),
     *                 @OA\Property(
     *                     property="link",
     *                     type="string",
     *                     format="url",
     *                     example="http://example.com/task/1"
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Task retrieved successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Task not found"
     *             )
     *         )
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        /** @var Task $task */
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            return $this->sendError('Task not found');
        }

        return $this->sendResponse('Task retrieved successfully', $task->toArray());
    }

    /**
     * Update the specified Task in storage.
     * PUT/PATCH /tasks/{id}
     */
    public function update($id, UpdateTaskAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Task $task */
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            return $this->sendError('Task not found');
        }

        $task = $this->taskRepository->update($input, $id);

        return $this->sendResponse('Task updated successfully', $task->toArray());
    }

    /**
     * Remove the specified Task from storage.
     * DELETE /tasks/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Task $task */
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            return $this->sendError('Task not found');
        }

        $task->delete();

        return $this->sendResponse('Task deleted successfully');
    }

    /**
     * Display tasks for a specified user.
     *
     * @OA\Get(
     *     path="/api/tasks/user/{id}",
     *     operationId="getTasksByUser",
     *     tags={"Tasks"},
     *     summary="Get tasks by user ID",
     *     description="Returns tasks for the specified user ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *         description="ID of the user whose tasks to retrieve"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tasks retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="desc",
     *                         type="string",
     *                         example="Task description"
     *                     ),
     *                     @OA\Property(
     *                         property="date",
     *                         type="string",
     *                         format="date",
     *                         example="2024-06-05"
     *                     ),
     *                     @OA\Property(
     *                         property="time",
     *                         type="string",
     *                         format="time",
     *                         example="14:00:00"
     *                     ),
     *                     @OA\Property(
     *                         property="assigned_to",
     *                         type="string",
     *                         example="John Doe"
     *                     ),
     *                     @OA\Property(
     *                         property="category",
     *                         type="string",
     *                         example="Development"
     *                     ),
     *                     @OA\Property(
     *                         property="link",
     *                         type="string",
     *                         format="url",
     *                         example="http://example.com/task/1"
     *                     )
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Tasks retrieved successfully"
     *             )
     *         )
     *     )
     * )
     */
    public function taskByUser($id)
    {
        $tasks = $this->taskRepository->findByField('user_id', $id);

        return $this->sendResponse('Tasks retrieved successfully', $tasks);
    }
}
