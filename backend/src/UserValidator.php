<?php

namespace Timkrysta\GravityGlobal;

class UserValidator
{
    public static function getStoreRequestValidator(array $data): Validator
    {
        $validationRules = [
            'name' => ['required', 'string', 'alpha_dash'],
            'username' => ['required', 'string', 'alpha_dash', 'unique'],
            'email' => ['required', 'email', 'unique'],
            'address' => ['array'],
            'address.street' => ['required', 'string'],
            'address.suite' => ['required', 'string'],
            'address.city' => ['required', 'string'],
            'address.zipcode' => ['required', 'string'],
            'website' => ['sometimes', 'string'],
            'company' => ['array'],
            'company.name' => ['required', 'string'],
            'company.catchPhrase' => ['sometimes', 'string'],
            'company.bs' => ['sometimes', 'string'],
        ];

        return new Validator($data, $validationRules);
    }

    public static function getDeleteRequestValidator(array $data): Validator
    {
        $validationRules = [
            'id' => ['required', 'numeric'],
        ];

        return new Validator($data, $validationRules);        
    }
}
