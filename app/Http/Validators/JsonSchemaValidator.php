<?php

namespace App\Http\Validators;

use App\Service\JsonSchema\Storage;
use JsonSchema\Validator;

class JsonSchemaValidator
{
    public function __construct(
        private Storage $storage,
    ) {
        //
    }

    public function validate(string $schemaName, array $value): array
    {
        return $this->doValidate($schemaName, $value);
    }

    private function doValidate(string $schemaName, array $value): array
    {
        $schema = (object) json_decode($this->storage->get($schemaName), false);

        $val = json_decode(json_encode($value));

        $validator = new Validator();
        $validator->validate($val, $schema);

        $errors = [];
        $i = 0;

        foreach ($validator->getErrors() as $error) {
            $errors[$error['property'] ?? $i++] = $error['message'];
        }

        return $errors;
    }
}
