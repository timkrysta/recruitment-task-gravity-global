<?php

namespace Timkrysta\GravityGlobal;

use Timkrysta\GravityGlobal\Models\User;

/** 
 * This class was heavily inspired by the way Laravel handles validation, with both simplicity and expand-ability in mind.
 * 
 * -----------------------------------------------------------------------------
 * ------------------------ Available Validation Rules -------------------------
 * -----------------------------------------------------------------------------
 * Below is a list of all available validation rules and their function:
 * 
 * 
 * 
 * -----------------------------------------------------------------------------
 * required
 * The field under validation must be present in the input data and not empty. A field is "empty" if it meets one of the following criteria:
 * -----------------------------------------------------------------------------
 * string
 * The field under validation must be a string.
 * -----------------------------------------------------------------------------
 * alpha_dash
 * The field under validation must be entirely Unicode alpha-numeric characters contained in \p{L}, \p{M}, \p{N}, as well as ASCII dashes (-) and ASCII underscores (_).
 * -----------------------------------------------------------------------------
 * unique
 * The field under validation must not exist within the datasource.
 * -----------------------------------------------------------------------------
 * email
 * The field under validation must be formatted as an email address.
 * -----------------------------------------------------------------------------
 * array
 * The field under validation must be a PHP array.
 * -----------------------------------------------------------------------------
 * sometimes
 * In some situations, you may wish to run validation checks against a field only if that field is present in the data being validated.
 * -----------------------------------------------------------------------------
 * url
 * The field under validation must be a valid URL.
 * -----------------------------------------------------------------------------
 */
class Validator
{
    private array $errors = [];

    public function __construct(
        private array $data, 
        private array $rules
    ) {}

    public function errors(): array
    {
        return $this->errors;
    }

    public function validate(): bool
    {
        foreach ($this->rules as $field => $rules) {
            $value = $this->getValue($field);

            foreach ($rules as $rule) {
                if ($rule === 'sometimes' && $value === null) break;

                $ruleParts = explode(':', $rule);
                $ruleName = $ruleParts[0];
                $parameters = isset($ruleParts[1]) ? explode(',', $ruleParts[1]) : [];

                $method = 'validate' . ucfirst($ruleName);

                if (method_exists($this, $method)) {
                    $this->$method($field, $value, $parameters);
                }
            }
        }

        return empty($this->errors);
    }

    private function getValue($field)
    {
        $fieldParts = explode('.', $field);
        $value = $this->data;

        foreach ($fieldParts as $part) {
            if (isset($value[$part])) {
                $value = $value[$part];
            } else {
                $value = null;
                break;
            }
        }

        return $value;
    }

    private function addError($field, $message)
    {
        $this->errors[$field][] = $message;
    }

    private function validateRequired($field, $value)
    {
        if (empty($value)) {
            $this->addError($field, "The {$field} field is required.");
        }
    }

    private function validateString($field, $value)
    {
        if (!is_string($value)) {
            $this->addError($field, "The {$field} field must be a string.");
        }
    }

    private function validateAlphaDash($field, $value)
    {
        if (!preg_match('/^[\p{L}\p{N}_-]+$/u', $value)) {
            $this->addError($field, "The {$field} field may only contain letters, numbers, dashes, and underscores.");
        }
    }

    private function validateUnique($field, $value)
    {
        $users = User::all();

        $arrayOfUsersFieldValues = array_column($users, $field);

        if (array_search($value, $arrayOfUsersFieldValues) !== false) {
            $this->addError($field, "The {$field} has already been taken.");
        }
    }

    private function validateEmail($field, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, "The {$field} field must be a valid email address.");
        }
    }

    private function validateArray($field, $value)
    {
        if (!is_array($value)) {
            $this->addError($field, "The {$field} field must be an array.");
        }
    }

    private function validateUrl($field, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            $this->addError($field, "The {$field} field must be a valid URL.");
        }
    }
}
