<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Services\UserService;

class ProjectController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getAllProjectData(Request $request)
    {
        $projectsData = $this->userService->getUserProject($request->user()->id);

        return response()->json([
            'project' => $projectsData,
        ]);
    }

    public function getProjectData(Request $request)
    {
        $projectData = $this->userService->getProjectData($request->project_id);

        return response()->json([
            'project' => $projectData,
        ]);
    }

    public function addProjectData(ProjectRequest $request)
    {
        $project = Project::create([
            'user_id' => $request->user()->id,
            'project_name' => $request->project_name
        ]);

        return response()->json([
            'message' => 'Add project.'
        ]);
    }
}
