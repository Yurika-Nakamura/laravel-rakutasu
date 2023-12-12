<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Services\TaskService;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function getTaskData(Request $request)
    {
        $taskData = $this->taskService->getTaskData($request->project_id);

        return response()->json([
            'task' => $taskData
        ]);
    }

    public function addTaskData(TaskRequest $request)
    {
        $this->taskService->addTaskData($request);

        return response()->json([
            'message' => 'Add task.'
        ]);
    }
}
