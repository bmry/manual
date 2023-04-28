<?php

namespace Manual\Dto;

class OptionDto
{
    /**
     * @param string $id
     * @param string $text
     * @param bool $selected
     */
    public function __construct(
        public readonly string $id,
        public readonly string $text,
        public readonly bool $selected = false,
        public array $questions = []
    ) {
    }

    public function addQuestions(QuestionDto $questionDto): void
    {
        $this->questions[] = $questionDto;
    }
}
