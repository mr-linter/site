<?php

namespace App\Http\Validators;

use Illuminate\Contracts\Validation\ValidationRule;

class JsonSchemaRule implements ValidationRule
{
    public function __construct(
        private JsonSchemaValidator $validator,
        private string $schemaName,
    ) {
        //
    }

    public function validate(string $field, mixed $value, \Closure $fail): void
    {
        $messages = $this->validator->validate($this->schemaName, $value);

        if (count($messages) === 0) {
            return;
        }

        foreach ($messages as $property => $error) {
            if ($property === '') {
                $message = $error;
            } else {
                $message = sprintf('%s: %s', $property, $error);
            }

            $fail($message);
        }
    }
}
