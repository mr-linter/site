<?php

namespace App\Http\Responses;

use App\Models\Analysis;
use Illuminate\Contracts\Support\Arrayable;

class ShareAnalysisResponse implements Arrayable
{
    public function __construct(
        private Analysis $analysis,
    ) {
        //
    }

    public function toArray()
    {
        return [
            'id' => $this->analysis->id,
        ];
    }
}
