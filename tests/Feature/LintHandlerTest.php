<?php

namespace Tests\Feature;

use Tests\TestCase;

final class LintHandlerTest extends TestCase
{
    public function providerForTestHandle(): array
    {
        return [
            [
                'requestData' => [
                    'mergeRequest' => [
                        'title' => 'test',
                        'has_conflicts' => false,
                        'is_draft' => false,
                        'can_merge' => true,
                        'source_branch' => 'feature/super-task',
                        'target_branch' => 'master',
                        'changed_files_count' => 500,
                    ],
                    'config' => [
                        'rules' => [
                            '@mr-linter/title_starts_with_task_number' => [],
                        ],
                        'ci' => [
                            'github_actions' => [
                                'credentials' => [
                                    'token' => '123',
                                ],
                            ],
                        ],
                    ],
                ],
                'expectedResult' => [
                    'notes' => [
                        [
                            'note' => 'Title must starts with task number of projects []',
                        ],
                    ],
                ],
            ],
            [
                'requestData' => [
                    'mergeRequest' => [
                        'title' => 'test',
                        'has_conflicts' => false,
                        'is_draft' => false,
                        'can_merge' => true,
                        'source_branch' => 'feature/super-task',
                        'target_branch' => 'master',
                        'changed_files_count' => 500,
                    ],
                    'config' => [
                        'rules' => [
                            '@mr-linter/title_starts_with_task_number' => [
                                'projectCodes' => [],
                            ],
                        ],
                        'ci' => [
                            'github_actions' => [
                                'credentials' => [
                                    'token' => '123',
                                ],
                            ],
                        ],
                    ],
                ],
                'expectedResult' => [
                    'notes' => [
                        [
                            'note' => 'Title must starts with task number of projects []',
                        ],
                    ],
                ],
            ],
            [
                'requestData' => [
                    'mergeRequest' => [
                        'title' => 'test',
                        'has_conflicts' => false,
                        'is_draft' => false,
                        'can_merge' => true,
                        'source_branch' => 'feature/super-task',
                        'target_branch' => 'master',
                        'changed_files_count' => 500,
                    ],
                    'config' => [
                        'rules' => [
                            '@mr-linter/title_starts_with_task_number' => [
                                'projectCodes' => ['ABC'],
                            ],
                        ],
                        'ci' => [
                            'github_actions' => [
                                'credentials' => [
                                    'token' => '123',
                                ],
                            ],
                        ],
                    ],
                ],
                'expectedResult' => [
                    'notes' => [
                        [
                            'note' => 'Title must starts with task number of projects [ABC]',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @covers \App\Http\Handlers\LintHandler::handle
     *
     * @dataProvider providerForTestHandle
     */
    public function testHandle(array $requestData, array $expectedResult): void
    {
        $this
            ->postJson('api/linter/lint', $requestData)
            ->assertOk()
            ->assertJson($expectedResult);
    }
}
