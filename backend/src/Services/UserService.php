<?php

namespace Timkrysta\GravityGlobal\Services;

use Timkrysta\GravityGlobal\Api;
use Timkrysta\GravityGlobal\Models\User;

class UserService
{
    public static function createNewUser()
    {
        
    }
    
    public static function deleteUserById(): bool
    {
        Api::exitIfRequestMethodNotSupported(['POST']);

        if (empty($_POST['userId'])) {
            return false;
        }

        return User::deleteById($_POST['userId']);
    }
    
    public static function getAllUsers(): array
    {
        Api::exitIfRequestMethodNotSupported(['GET']);
        $users = User::all();
        return $users;
    }
}
