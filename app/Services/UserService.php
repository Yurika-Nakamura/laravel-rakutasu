<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;

class UserService
{
    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getUserData($data)
    {
        return $this->projectRepository->getProjectsData($data);
    }
    public function getProjectData($data)
    {
        return $this->projectRepository->getProjectData($data);
    }
}