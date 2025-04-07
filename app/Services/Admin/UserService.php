<?php

namespace App\Services\Admin;

use App\Models\User;

class UserService
{
    public function __construct()
    {

    }

    public function createUser($data)
    {
        $user = User::query()->create($data);
        return $user;
    }
}
