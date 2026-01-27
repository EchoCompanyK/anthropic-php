<?php

declare(strict_types=1);

namespace Anthropic\Responses\Messages;

final class CreateStreamedResponseUsage
{
    private function __construct(
        public readonly ?int $inputTokens,
        public readonly ?int $outputTokens,
        public readonly ?int $cacheCreationInputTokens,
        public readonly ?int $cacheReadInputTokens,
        public readonly ?int $cacheCreation5m,
        public readonly ?int $cacheCreation1h,
    ) {}

    /**
     * @param  array{
     *   input_tokens?: int,
     *   output_tokens?: int,
     *   cache_creation_input_tokens?: int|null,
     *   cache_read_input_tokens?: int|null,
     *   cache_creation?: array{ephemeral_5m_input_tokens?: int, ephemeral_1h_input_tokens?: int}
     * }  $attributes
     */
    public static function from(array $attributes): self
    {
        $cacheCreation = $attributes['cache_creation'] ?? [];

        return new self(
            $attributes['input_tokens'] ?? null,
            $attributes['output_tokens'] ?? null,
            $attributes['cache_creation_input_tokens'] ?? null,
            $attributes['cache_read_input_tokens'] ?? null,
            $cacheCreation['ephemeral_5m_input_tokens'] ?? null,
            $cacheCreation['ephemeral_1h_input_tokens'] ?? null,
        );
    }

    /**
     * @return array{
     *   input_tokens: int|null,
     *   output_tokens: int|null,
     *   cache_creation_input_tokens: int|null,
     *   cache_read_input_tokens: int|null,
     *   cache_creation?: array{ephemeral_5m_input_tokens: int|null, ephemeral_1h_input_tokens: int|null}
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

        if ($this->cacheCreation5m !== null || $this->cacheCreation1h !== null) {
            $result['cache_creation'] = [
                'ephemeral_5m_input_tokens' => $this->cacheCreation5m,
                'ephemeral_1h_input_tokens' => $this->cacheCreation1h,
            ];
        }

        return $result;
    }
}
