<?php

namespace Timkrysta\GravityGlobal\Controllers;

use Timkrysta\GravityGlobal\Api;
use Timkrysta\GravityGlobal\Models\User;
use Timkrysta\GravityGlobal\Response;
use Timkrysta\GravityGlobal\Sanitizer;
use Timkrysta\GravityGlobal\UserValidator;

class UserController
{
    public static function createNewUser()
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

        Response::json(['message' => 'Success'], 201);
    }
    
    public static function deleteUserById()
    {
        Api::exitIfRequestMethodNotSupported(['POST']);

        $data = [
            'id' => $_POST['userId'],
        ];

        $validator = UserValidator::getDeleteRequestValidator($data);
        
        if (! $validator->validate()) {
            Response::validationFailed($validator->errors());
        }

        if (User::deleteById($data['id'])) {
            Response::json(['message' => 'Success']);
        } else {
            Response::json(['message' => 'Error: operation unsuccessful'], 400);
        }
    }
    
    public static function returnAllUsers()
    {
        Api::exitIfRequestMethodNotSupported(['GET']);

        $users = User::all();

        Response::json($users);
    }
}
