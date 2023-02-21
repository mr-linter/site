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

    public function get(string $name): string
    {
        return $this->files->get(sprintf('%s.json', $name));
    }
}
