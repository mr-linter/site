<?php

namespace Tests\Unit\Text\Json\Schema;

use App\Http\Validators\JsonSchemaValidator;
use App\Service\JsonSchema\Storage;
use Psr\Log\NullLogger;
use Tests\TestCase;

class JsonSchemaValidatorTest extends TestCase
{
    public function providerForTestValidate(): array
    {
        return [
            [
                __DIR__ . '/data/json_schema_validator_validate_data_1.json',
                __DIR__ . '/../../../../../storage/app/json-schemas/mr_linter_config.json',
                __DIR__ . '/data/json_schema_validator_validate_1_expected.json',
            ],
        ];
    }

    /**
     * @dataProvider providerForTestValidate
     */
    public function testValidate(string $dataPath, string $schemaPath, string $expected): void
    {
        $validator = new JsonSchemaValidator($this->mockStorage($schemaPath), new NullLogger());

        self::assertEquals(
            json_decode(file_get_contents($expected), true),
            $validator->validate(
                '',
                json_decode(file_get_contents($dataPath), true),
            ),
        );
    }

    private function mockStorage(string $schemaPath): Storage
    {
        return new class ($schemaPath) implements \App\Service\JsonSchema\Storage {
            public function __construct(private string $schema)
            {
                //
            }

            public function get(string $name): string
            {
                return file_get_contents($this->schema);
            }
        };
    }
}
