<?php

namespace Timkrysta\GravityGlobal;

class Response
{
    /**
     * Returns JSON response and exits
     */
    public static function json(mixed $data, int $responseCode = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($responseCode);
        echo json_encode($data);
        exit();
    }
}
