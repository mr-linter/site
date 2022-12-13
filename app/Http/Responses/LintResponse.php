<?php

namespace App\Http\Responses;

use ArtARTs36\MergeRequestLinter\Linter\LintResult;
use Illuminate\Contracts\Support\Arrayable;

class LintResponse implements Arrayable
{
    public function __construct(
        private LintResult $result,
    ) {
        //
    }

    public function toArray()
    {
        $notes = [];

        foreach ($this->result->notes as $note) {
            $notes[] = [
                'description' => $note->getDescription(),
                'color' => $note->getColor()->value,
            ];
        }

        return [
            'result' => $this->result->state,
            'notes' => $notes,
            'duration' => $this->result->duration,
        ];
    }
}
