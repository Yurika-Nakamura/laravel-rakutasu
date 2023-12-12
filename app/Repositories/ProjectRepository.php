<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserToken;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;

class ProjectRepository
{
    public function getProjectsData($data)
    {
        return Project::where('user_id', $data)->get();
    }

    public function getProjectData($data)
    {
        return Project::where('id', $data)->first();
    }
    public function checkEmail($data)
    {
        return User::where('email', $data['email'])->first();
    }

}