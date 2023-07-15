<?php

namespace Timkrysta\GravityGlobal;

class Sanitizer
{
    /**
     * This method runs the passed $data through `htmlspecialchars` and returns the result.
     * The purpose of this action is to encode dangerous chars and prevent XSS.
     */
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
