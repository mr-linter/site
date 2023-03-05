<?php

namespace App\Http\Validators;

use App\Service\JsonSchema\Storage;
use JsonSchema\Constraints\Constraint;
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
        $schema = $this->storage->get($schemaName)->object;

        $val = json_decode(json_encode($value));

        $validator = new Validator();
        $validator->validate($val, $schema, Constraint::CHECK_MODE_COERCE_TYPES);

        $errors = [];
        $i = 0;

        foreach ($validator->getErrors() as $error) {
            $errors[$error['property'] ?? $i++] = $error['message'];
        }

        return $errors;
    }
}
