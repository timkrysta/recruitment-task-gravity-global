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
            $this->assertSame(201, $response->getStatusCode());
        } catch (ClientException $e) {
            $this->assertTrue(false);
        }
    }

    public function test_empty_store_request_fails(): void
    {
        try {
            $response = $this->client->post(self::STORE_API_ENDPOINT, [ 'form_params' => [] ]);
        } catch (ClientException $e) {
            $this->assertSame(422, $e->getResponse()->getStatusCode());
        }
    }

    public function test_validation_fails_invaild_name(): void
    {
        // Empty
        try {
            $response = $this->addUser([ 'name' => '' ]);
        } catch (ClientException $e) {
            $this->assertSame(422, $e->getResponse()->getStatusCode());
        }
        
        // Invalid chars
        try {
            $response = $this->addUser([ 'name' => '?<ntaoehun' ]);
        } catch (ClientException $e) {
            $this->assertSame(422, $e->getResponse()->getStatusCode());
        }
    }
    
    public function test_validation_fails_invaild_username(): void
    {
        // Empty
        try {
            $response = $this->addUser([ 'username' => '' ]);
        } catch (ClientException $e) {
            $this->assertSame(422, $e->getResponse()->getStatusCode());
        }

        // Invalid chars
        try {
            $response = $this->addUser([ 'username' => '?<ntaoehun' ]);
        } catch (ClientException $e) {
            $this->assertSame(422, $e->getResponse()->getStatusCode());
        }
        
        // Not unique
        $uniqueUsername = 'unique_username' . uniqid();
        $response = $this->addUser([ 'username' => $uniqueUsername ]);
        $this->assertSame(201, $response->getStatusCode());
        try {
            $response = $this->addUser([ 'username' => $uniqueUsername ]);
        } catch (ClientException $e) {
            $this->assertSame(422, $e->getResponse()->getStatusCode());
        }
    }
    
    public function test_validation_fails_invaild_email(): void
    {
        // Empty
        try {
            $response = $this->addUser([ 'email' => '' ]);
        } catch (ClientException $e) {
            $this->assertSame(422, $e->getResponse()->getStatusCode());
        }
        
        // Not unique
        $uniqueEmail = 'unique_email' . uniqid() . '@example.com';
        $response = $this->addUser([ 'email' => $uniqueEmail ]);
        $this->assertSame(201, $response->getStatusCode());
        try {
            $response = $this->addUser([ 'email' => $uniqueEmail ]);
        } catch (ClientException $e) {
            $this->assertSame(422, $e->getResponse()->getStatusCode());
        }
    }
    
    public function test_validation_fails_invaild_phone(): void
    {
        // Empty
        try {
            $response = $this->addUser([ 'phone' => '' ]);
        } catch (ClientException $e) {
            $this->assertSame(422, $e->getResponse()->getStatusCode());
        }
    }
    
    public function test_validation_fails_invaild_address(): void
    {
        // Empty
        try {
            $response = $this->addUser([ 'address' => [] ]);
        } catch (ClientException $e) {
            $this->assertSame(422, $e->getResponse()->getStatusCode());
        }
    }
    
    public function test_validation_fails_invaild_company(): void
    {
        // Empty
        try {
            $response = $this->addUser([ 'company' => [] ]);
        } catch (ClientException $e) {
            $this->assertSame(422, $e->getResponse()->getStatusCode());
        }
    }
}
