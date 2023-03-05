<?php

namespace App\Service\JsonSchema;

use Illuminate\Contracts\Filesystem\Filesystem;

class FileStorage implements Storage
{
    public function __construct(
        private Filesystem $files,
    ) {
        //
    }

    public function get(string $name): JsonObject
    {
        $file = $this->files->get(sprintf('%s.json', $name));

        $schema = (object) json_decode($file, false);

        return new JsonObject($schema);
    }
}
