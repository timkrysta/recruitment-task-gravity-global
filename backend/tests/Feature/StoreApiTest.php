<?php

declare(strict_types=1);

require_once __DIR__.'/../support/ApiTest.php';

use GuzzleHttp\Exception\ClientException;

final class StoreApiTest extends ApiTest
{
    public function test_store_user_success(): void
    {
        try {
            $response = $this->addUser();
        } catch (ClientException $e) {
            $this->assertTrue(false);
            return;
        }
        $this->assertSame(201, $response->getStatusCode());
    }

    public function test_empty_store_request_fails(): void
    {
        try {
            $response = $this->client->post(self::STORE_API_ENDPOINT, [
                'form_params' => []
            ]);
        } catch (ClientException $e) {
            $this->assertTrue(true);
            return;
        }
        $this->assertSame(422, $response->getStatusCode());
    }
}
