<?php

namespace App\Http\Requests;

use App\Http\Validators\JsonSchemaRule;
use Illuminate\Foundation\Http\FormRequest;

final class LintRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mergeRequest.title' => 'required|string',
            'mergeRequest.description' => 'nullable|string',
            'mergeRequest.labels' => 'array',
            'mergeRequest.labels.*' => 'string',
            'mergeRequest.has_conflicts' => 'required',
            'mergeRequest.is_draft' => 'required',
            'mergeRequest.can_merge' => 'required',
            'mergeRequest.source_branch' => 'required|string',
            'mergeRequest.target_branch' => 'required|string',
            'mergeRequest.changed_files_count' => 'required|integer',
            'config' => [
                'required',
                'array',
                $this->container->make(JsonSchemaRule::class, [
                    'schemaName' => 'mr_linter_config',
                ]),
            ],
        ];
    }

    public function getMergeRequest(): array
    {
        $array = $this->input('mergeRequest');
        $array['description'] = $array['description'] ?? '';
        $array['labels'] = $array['labels'] ?? [];

        return $array;
    }
}
