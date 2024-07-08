<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Models\Task;

class TaskService {

    public function getAllTasks(array $data)
    {
        $tasks = Task::all();

        if (array_key_exists('status_id', $data)) {
            $tasks = $tasks->where('status_id', $data['status_id']);
        }

        if (array_key_exists('due_date', $data)) {
            $tasks = $tasks->where('due_date', $data['due_date']);
        }

        return $tasks;
    }

    public function getTask($id)
    {
        $task = Task::find($id);
        
        return $task;
    }

    public function createTask($data)
    {
        if (!isset($data['status_id'])) {
            $data['status_id'] = 1;
        }

        $task = Task::create($data);
        
        return $task;
    }

    public function updateTask($id, $data)
    {
        $task = Task::find($id);
    
        if (isset($task)) {
            $task->update($data);
        }

        return $task;
    }

    public function deleteTask($id)
    {
        $task = Task::find($id);

        if (!isset($task)) {
            return false;
        }

        $deleted = $task->delete();

        return $deleted;
    }
}