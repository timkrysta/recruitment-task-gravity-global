<?php

namespace Timkrysta\GravityGlobal;

class Sanitizer
{
    public static function sanitize($data)
    {
        if (! is_array($data)) {
            return htmlspecialchars($data); 
        }
        
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = self::sanitize($value);
            } else {
                $data[$key] = htmlspecialchars($value);
            }
        }

        return $data;
    }
}
