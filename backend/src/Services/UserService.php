<?php

namespace Timkrysta\GravityGlobal\Services;

use Timkrysta\GravityGlobal\Api;
use Timkrysta\GravityGlobal\Models\User;

class UserService
{
    public static function createNewUser(): bool
    {
        Api::exitIfRequestMethodNotSupported(['POST']);

        $lastId = User::getLatestUserId();

        User::create([
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
        ]);

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
