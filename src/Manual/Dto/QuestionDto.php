<?php

namespace Manual\Dto;

class QuestionDto
{
    private array $options = [];

    /**
     * @param string $id
     * @param string $text
     * @param array $options
     * @param array $optionalCondition
     */
    public function __construct(
        public readonly string $id,
        public readonly string $text,
        public readonly int $position
    ) {
    }

    /**
     * @param OptionDto $option
     */
    public function addOption(OptionDto $option)
    {
        $this->options[] = $option;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
