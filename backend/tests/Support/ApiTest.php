<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class ApiTest extends TestCase
{
    protected Client $client;
    protected const STORE_API_ENDPOINT  = '/api/users/store.php';
    protected const GET_API_ENDPOINT    = '/api/users/getAll.php';
    protected const DELETE_API_ENDPOINT = '/api/users/deleteById.php';

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        $this->client = new Client(['base_uri' => 'http://localhost:8080']);
    }

    protected function getUser($attributes = [])
    {
        $faker = \Faker\Factory::create();

        $user = [
            "name" => "Leanne Graham",
            "username" => $faker->unique()->userName(),
            "email" => $faker->unique()->email(),
            "address" => [
                "street" => "Kulas Light",
                "suite" => "Apt. 556",
                "city" => "Gwenborough",
                "zipcode" => "92998-3874",
                "geo" => [
                    "lat" => "-37.3159",
                    "lng" => "81.1496"
                ]
            ],
            "phone" => "1-770-736-8031 x56442",
            "website" => "hildegard.org",
            "company" => [
                "name" => "Romaguera-Crona",
                "catchPhrase" => "Multi-layered client-server neural-net",
                "bs" => "harness real-time e-markets"
            ]
        ];
        
        $user = array_merge($user, $attributes);

        return $user;
    }
    
    protected function addUser($attributes = [])
    {
        $response = $this->client->post(self::STORE_API_ENDPOINT, [
            'form_params' => $this->getUser($attributes),
            'debug' => true,
        ]);
        return $response;
    }

    protected function deleteUser(int|null $userId)
    {
        $response = $this->client->post(self::DELETE_API_ENDPOINT, [
            'form_params' => [
                'userId' => $userId,
            ],
            'debug' => true,
        ]);
        return $response;
    }
}
