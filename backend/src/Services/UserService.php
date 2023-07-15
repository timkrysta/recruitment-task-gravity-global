<?php

namespace Timkrysta\GravityGlobal\Services;

use Timkrysta\GravityGlobal\Api;
use Timkrysta\GravityGlobal\Models\User;
use Timkrysta\GravityGlobal\Response;
use Timkrysta\GravityGlobal\Sanitizer;
use Timkrysta\GravityGlobal\UserValidator;

class UserService
{
    public static function createNewUser(): bool
    {
        Api::exitIfRequestMethodNotSupported(['POST']);

        $data = [
            'id' => User::getLatestUserId() + 1,
            'name' => $_POST['name'],
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'website' => $_POST['website'],
            'address' => $_POST['address'],
            'company' => $_POST['company'],
        ];

        $validator = UserValidator::getStoreRequestValidator($data);
        
        if (! $validator->validate()) {
            Response::validationFailed($validator->errors());
        }

        $data = Sanitizer::sanitize($data);

        User::create($data);

        return true;
    }
    
    public static function deleteUserById(): bool
    {
        Api::exitIfRequestMethodNotSupported(['POST']);

        $data = [
            'id' => $_POST['userId'],
        ];

        $validator = UserValidator::getDeleteRequestValidator($data);
        
        if (! $validator->validate()) {
            Response::validationFailed($validator->errors());
        }

        return User::deleteById($data['id']);
    }
    
    public static function getAllUsers(): array
    {
        Api::exitIfRequestMethodNotSupported(['GET']);
        $users = User::all();
        return $users;
    }
}
