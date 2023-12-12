<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;

class TaskRepository
{
    public function getTaskData($data)
    {
        return Task::where('project_id', $data)->get();
    }

    public function addTaskData($data)
    {
        return Task::create([
            'project_id' => $data->project_id,
            'task_title' => $data->task_title,
        ]);
    }
}