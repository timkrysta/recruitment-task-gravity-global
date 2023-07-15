<?php

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
            $this->client->post(self::STORE_API_ENDPOINT, [ 'form_params' => [] ]);
        } catch (ClientException $e) {
            $this->assertSame(422, $e->getResponse()->getStatusCode());
        }
    }

    public function test_validation_fails_invaild_name(): void
    {
        $this->test_submitting_these_attributes_fails(['name' => '']);
        
        $this->test_submitting_these_attributes_fails(['name' => '<script>alert("XSS-ed");</script>']);
    }
    
    public function test_validation_fails_invaild_username(): void
    {
        $this->test_submitting_these_attributes_fails(['username' => '']);

        $this->test_submitting_these_attributes_fails(['username' => '<script>alert("XSS-ed");</script>']);
        
        // Not unique
        $uniqueUsername = 'unique_username' . uniqid();
        $response = $this->addUser([ 'username' => $uniqueUsername ]);
        $this->assertSame(201, $response->getStatusCode());
        $this->test_submitting_these_attributes_fails(['username' => $uniqueUsername]);
    }
    
    public function test_validation_fails_invaild_email(): void
    {
        $this->test_submitting_these_attributes_fails(['email' => '']);
        
        // Not unique
        $uniqueEmail = 'unique_email' . uniqid() . '@example.com';
        $response = $this->addUser([ 'email' => $uniqueEmail ]);
        $this->assertSame(201, $response->getStatusCode());
        $this->test_submitting_these_attributes_fails(['email' => $uniqueEmail]);
    }
    
    public function test_validation_fails_invaild_phone(): void
    {
        $this->test_submitting_these_attributes_fails(['phone' => '']);
    }
    
    public function test_validation_fails_invaild_address(): void
    {
        $this->test_submitting_these_attributes_fails(['address' => []]);
    }
    
    public function test_validation_fails_invaild_company(): void
    {
        $this->test_submitting_these_attributes_fails(['company' => []]);
    }
    
    private function test_submitting_these_attributes_fails(array $attributes): void
    {
        try {
            $this->addUser($attributes);
        } catch (ClientException $e) {
            $this->assertSame(422, $e->getResponse()->getStatusCode());
        }
    }
}
