<?php

namespace App\Http\Validators;

use App\Service\JsonSchema\Storage;
use Opis\JsonSchema\ValidationResult;
use Opis\JsonSchema\Validator;

class JsonSchemaValidator
{
    private array $errors = [];

    public function __construct(
        private Storage $storage,
        private Validator $validator,
    ) {
        //
    }

    public function validate($attribute, $value, $parameters, $validator): array
    {
        $result = $this->doValidate($parameters[0], $value);

        $error = $result->error();

        if ($error === null) {
            $this->errors = [];

            return [];
        }

        $this->errors[] = $error->message();

        foreach ($error->subErrors() as $error) {
            $this->errors[] = $error->message();
        }

        return $this->errors;
    }

    private function doValidate(string $schemaName, array $value): ValidationResult
    {
        $schema = $this->storage->get($schemaName);

        return $this->validator->validate($value, $schema);
    }

    public function message()
    {
        return $this->errors;
    }
}
