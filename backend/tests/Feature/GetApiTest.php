<?php

require_once __DIR__.'/../support/ApiTest.php';

use GuzzleHttp\Exception\ClientException;
use Timkrysta\GravityGlobal\Models\User;

final class GetApiTest extends ApiTest
{
    public function test_get_users_success(): void
    {
        $response = $this->addUser();
        $usersInDb = User::all();
        
        try {
            $response = $this->client->get(self::GET_API_ENDPOINT);
            $users = json_decode($response->getBody());
            $this->assertTrue(count($usersInDb) === count($users));
        } catch (ClientException $e) {
            $this->assertTrue(false);
        }
    }
}
