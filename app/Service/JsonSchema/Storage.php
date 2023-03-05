<?php

namespace App\Service\JsonSchema;

interface Storage
{
    /**
     * @param string $name - Schema name
     */
    public function get(string $name): JsonObject;
}
