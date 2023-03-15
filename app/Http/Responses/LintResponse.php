<?php

namespace App\Http\Responses;

use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Note\Note;
use Illuminate\Contracts\Support\Arrayable;

class LintResponse implements Arrayable
{
    public function __construct(
        private string $linterVersion,
        private LintResult $result,
    ) {
        //
    }

    public function toArray(): array
    {
        $notes = [];

        /**
         * @var Note $note
         */
        foreach ($this->result->notes as $note) {
            $notes[] = [
                'note' => $note->getDescription(),
                'severity' => $note->getSeverity(),
            ];
        }

        return [
            'linter_version' => $this->linterVersion,
            'result' => $this->result->state,
            'notes' => $notes,
            'duration' => $this->result->duration,
        ];
    }
}
