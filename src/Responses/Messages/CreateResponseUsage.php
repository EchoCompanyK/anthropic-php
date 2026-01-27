<?php

declare(strict_types=1);

namespace Anthropic\Responses\Messages;

final class CreateResponseUsage
{
    private function __construct(
        public readonly int $inputTokens,
        public readonly int $outputTokens,
        public readonly int $cacheCreationInputTokens,
        public readonly int $cacheReadInputTokens,
        public readonly int $cacheCreation5m,
        public readonly int $cacheCreation1h,
    ) {}

    /**
     * @param  array{
     *   input_tokens: int,
     *   cache_creation_input_tokens: int|null,
     *   cache_read_input_tokens: int|null,
     *   output_tokens: int,
     *   cache_creation?: array{ephemeral_5m_input_tokens?: int, ephemeral_1h_input_tokens?: int}
     * }  $attributes
     */
    public static function from(array $attributes): self
    {
        $cacheCreation = $attributes['cache_creation'] ?? [];

        return new self(
            $attributes['input_tokens'],
            $attributes['output_tokens'],
            $attributes['cache_creation_input_tokens'] ?? 0,
            $attributes['cache_read_input_tokens'] ?? 0,
            $cacheCreation['ephemeral_5m_input_tokens'] ?? 0,
            $cacheCreation['ephemeral_1h_input_tokens'] ?? 0,
        );
    }

    /**
     * @return array{
     *   input_tokens: int,
     *   output_tokens: int,
     *   cache_creation_input_tokens: int,
     *   cache_read_input_tokens: int,
     *   cache_creation?: array{ephemeral_5m_input_tokens: int, ephemeral_1h_input_tokens: int}
     * }
     */
    public function toArray(): array
    {
        $result = [
            'input_tokens' => $this->inputTokens,
            'output_tokens' => $this->outputTokens,
            'cache_creation_input_tokens' => $this->cacheCreationInputTokens,
            'cache_read_input_tokens' => $this->cacheReadInputTokens,
        ];

        if ($this->cacheCreation5m > 0 || $this->cacheCreation1h > 0) {
            $result['cache_creation'] = [
                'ephemeral_5m_input_tokens' => $this->cacheCreation5m,
                'ephemeral_1h_input_tokens' => $this->cacheCreation1h,
            ];
        }

        return $result;
    }
}
