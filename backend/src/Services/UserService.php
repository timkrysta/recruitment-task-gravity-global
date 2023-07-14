<?php

namespace Timkrysta\GravityGlobal\Services;

use Timkrysta\GravityGlobal\Api;
use Timkrysta\GravityGlobal\Models\User;
use Timkrysta\GravityGlobal\Response;
use Timkrysta\GravityGlobal\Sanitizer;
use Timkrysta\GravityGlobal\Validator;

class UserService
{
    public static function createNewUser(): bool
    {
        Api::exitIfRequestMethodNotSupported(['POST']);

        $validationRules = [
            'name' => ['required', 'string', 'alpha_dash'],
            'username' => ['required', 'string', 'alpha_dash', 'unique'],
            'email' => ['required', 'email', 'unique'],
            'address' => ['array'],
            'address.street' => ['required', 'string'],
            'address.suite' => ['required', 'string'],
            'address.city' => ['required', 'string'],
            'address.zipcode' => ['required', 'string'],
            'website' => ['sometimes', 'url'],
            'company' => ['array'],
            'company.name' => ['required', 'string'],
            'company.catchPhrase' => ['sometimes', 'string'],
            'company.bs' => ['sometimes', 'string'],
        ];

        $lastId = User::getLatestUserId();
        
        $data = [
            'id' => $lastId + 1,
            'name' => $_POST['name'],
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address'],
            'company' => $_POST['company'],
            /* 'address' => [
                'street' => "Kulas Light",
                'suite' => "Apt. 556",
                'city' => "Gwenborough",
                'zipcode' => "92998-3874",
                "geo" => [
                    "lat" => "-37.3159",
                    "lng" => "81.1496",
                ],
            ],
            'company' => [
                'name' => "Romaguera-Crona",
                'catchPhrase' => "Multi-layered client-server neural-net",
                'bs' => "harness real-time e-markets",
            ], */
        ];

        $validator = new Validator($data, $validationRules);
        
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
