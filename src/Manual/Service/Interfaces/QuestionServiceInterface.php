<?php

namespace Manual\Service\Interfaces;

use Manual\Entity\Questionnaire;

interface QuestionServiceInterface
{
    public function getQuestionsByQuestionnaire(Questionnaire $questionnaire): iterable;
}
