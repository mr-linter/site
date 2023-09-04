<?php

namespace App\Http\Validators;

use App\Service\JsonSchema\Storage;
use JsonSchema\Constraints\Constraint;
use JsonSchema\Validator;
use Psr\Log\LoggerInterface;

class JsonSchemaValidator
{
    public function __construct(
        private Storage $storage,
        private LoggerInterface $logger,
    ) {
        //
    }

    public function validate(string $schemaName, array $value): array
    {
        $this->logger->debug(sprintf(
            '[JsonSchemaValidator] fetching schema "%s"',
            $schemaName,
        ));

        $schemaFetchStarted = microtime(true);

        $schema = $this->storage->get($schemaName);

        $this->logger->debug(sprintf(
            '[JsonSchemaValidator] schema "%s" fetched',
            $schemaName,
        ), [
            'duration' => microtime(true) - $schemaFetchStarted,
        ]);

        return $this->doValidate($schemaName, $schema->object, $value);
    }

    private function doValidate(string $schemaName, object $schema, array $value): array
    {
        $val = json_decode($jsonVal = json_encode($value));

        $this->logger->debug(sprintf(
            '[JsonSchemaValidator] validating value at schema "%s"',
            $schemaName,
        ), [
            'value_length' => strlen($jsonVal),
        ]);

        $validationStarted = microtime(true);

        $validator = new Validator();
        $validator->validate($val, $schema, Constraint::CHECK_MODE_COERCE_TYPES);

        $this->logger->debug(sprintf(
            '[JsonSchemaValidator] validating finished at schema "%s"',
            $schemaName,
        ), [
            'duration' => microtime(true) - $validationStarted,
            'value_length' => strlen($jsonVal),
        ]);

        $errors = [];
        $i = 0;

        foreach ($validator->getErrors() as $error) {
            $errors[$error['property'] ?? $i++] = $error['message'];
        }

        return $errors;
    }
}
