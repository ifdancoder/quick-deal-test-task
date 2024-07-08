<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

use App\Models\Task;
use App\Services\TaskService;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskCollection;

class TaskController
{
    private $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        $tasks = $this->taskService->getAllTasks();

        if ($tasks) {
            return new JsonResponse(['success' => true, 'data' => (new TaskCollection($tasks))->toArray($request)], 200);
        }

        return new JsonResponse(['success' => false], 400);
    }

    public function store(CreateTaskRequest $request)
    {
        $task = $this->taskService->createTask($request->validated());

        if ($task) {
            return new JsonResponse(['success' => true, 'data' => (new TaskResource($task))->toArray($request)], 200);
        }

        return new JsonResponse(['success' => false], 400);
    }

    public function show(Request $request, $id)
    {
        $task = $this->taskService->getTask($id);

        if ($task) {
            return new JsonResponse(['success' => true, 'data' => (new TaskResource($task))->toArray($request)], 200);
        }

        return new JsonResponse(['success' => false], 400);
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        $task = $this->taskService->updateTask($id, $request->validated());

        if ($task) {
            return new JsonResponse(['success' => true, 'data' => (new TaskResource($task))->toArray($request)], 200);
        }

        return new JsonResponse(['success' => false], 400);
    }

    public function destroy(Request $request, $id)
    {
        $deleted = $this->taskService->deleteTask($id);

        if ($deleted) {
            return new JsonResponse(['success' => true], 200);
        }

        return new JsonResponse(['success' => false], 400);
    }
}
