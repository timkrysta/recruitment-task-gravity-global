<?php

use Timkrysta\GravityGlobal\Response;
use Timkrysta\GravityGlobal\Services\UserService;

require_once __DIR__ . '/../../vendor/autoload.php';

$users = UserService::getAllUsers();

Response::json($users);
