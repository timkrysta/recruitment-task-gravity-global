<?php

declare(strict_types=1);

require_once __DIR__.'/../support/ApiTest.php';

use GuzzleHttp\Exception\ClientException;
use Timkrysta\GravityGlobal\Models\User;

final class DeleteApiTest extends ApiTest
{
    public function test_delete_user_success(): void
    {
        try {
            $response = $this->addUser();
            $lastId = User::getLatestUserId();
            $this->deleteUser($lastId);
            $newLastId = User::getLatestUserId();
            $this->assertTrue($lastId !== $newLastId);
        } catch (ClientException $e) {
            $this->assertTrue(false);
        }
    }

    public function test_empty_store_request_fails(): void
    {
        try {
            $response = $this->addUser();
            $this->deleteUser(null);
        } catch (ClientException $e) {
            $this->assertSame(422, $e->getResponse()->getStatusCode());
        }
    }
}
