<?php

namespace App\Service\Linter;

use ArtARTs36\MergeRequestLinter\Domain\Request\Author;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\MarkdownCleaner;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\Str\Markdown;
use ArtARTs36\Str\Str;

class MergeRequestFactory
{
    public function __construct(
        private MarkdownCleaner $markdownCleaner,
    ) {
        //
    }

    public function create(array $data): MergeRequest
    {
        $description = Str::make($data['description'] ?? '');

        return new MergeRequest(
            Str::make($data['title'] ?? ''),
            new Markdown($description),
            $this->markdownCleaner->clean($description),
            Set::fromList($data['labels'] ?? []),
            $data['has_conflicts'] ?? false,
            Str::make($data['source_branch'] ?? 'development'),
            Str::make($data['target_branch'] ?? 'master'),
            new Author(Str::make($data['author']['login'] ?? 'developer')),
            $data['is_draft'] ?? false,
            $data['can_merge'] ?? false,
            isset($data['changed_files_count']) ? new ArrayMap(range(0, $data['changed_files_count'])) : new ArrayMap([]),
            isset($data['created_at']) ? new \DateTimeImmutable($data['created_at']) : new \DateTimeImmutable(),
            Str::make($data['uri'] ?? ''),
        );
    }
}
