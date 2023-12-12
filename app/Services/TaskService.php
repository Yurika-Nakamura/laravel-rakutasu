<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;

class TaskService
{
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getTaskData($data)
    {
        return $this->taskRepository->getTaskData($data);
    }

    public function addTaskData($data)
    {
        return $this->taskRepository->addTaskData($data);
    }
}