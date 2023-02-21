<?php

namespace App\Service\JsonSchema;

interface Storage
{
    /**
     * @param string $name - Schema name
     * @return string content of json schema
     */
    public function get(string $name): string;
}
