<?php

namespace App\Http\Requests;

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
            'mergeRequest.source_branch' => 'required|string',
            'mergeRequest.target_branch' => 'required|string',
            'mergeRequest.changed_files_count' => 'required|integer',
        ];
    }

    public function getMergeRequest(): array
    {
        $array = $this->input('mergeRequest');
        $array['has_conflicts'] = isset($array['has_conflicts']) && $array['has_conflicts'] === 'true';
        $array['description'] = $array['description'] ?? '';
        $array['labels'] = $array['labels'] ?? [];

        return $array;
    }
}
