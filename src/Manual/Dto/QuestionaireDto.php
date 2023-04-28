<?php

namespace Manual\Dto;

class QuestionaireDto
{
    private array $questions = [];

    /**
     * @param string $title
     * @param string $description
     * @param array $questions
     */
    public function __construct(
        public string $title,
        public string $description = ""
    ) {
    }

    public function addQuestion(QuestionDto $questionDto)
    {
        $this->questions[] = $questionDto;
    }

    public function getQuestions()
    {
        return $this->questions;
    }
}
