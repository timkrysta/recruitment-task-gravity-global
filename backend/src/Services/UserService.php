<?php

namespace Timkrysta\GravityGlobal\Services;

use Timkrysta\GravityGlobal\Models\User;

class UserService
{
    public static function createNewUser()
    {
        
    }
    
    public static function deleteUserById(int $userId)
    {
        
    }
    
    public static function getAllUsers(): array
    {
        $users = User::all();
        return $users;
    }
}
