<?php

use Timkrysta\GravityGlobal\Response;
use Timkrysta\GravityGlobal\Services\UserService;

require_once __DIR__ . '/../../vendor/autoload.php';

if (UserService::deleteUserById()) {
    Response::json(['message' => 'Success']);
} else {
    Response::json(['message' => 'Error: operation unsuccessful'], 400);
}
