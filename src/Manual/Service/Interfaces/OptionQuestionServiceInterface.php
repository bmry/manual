<?php

namespace Manual\Service\Interfaces;

use Manual\Entity\Questionnaire;

interface OptionQuestionServiceInterface
{
    public function getOptionalQuestionsByQuestionnaire(Questionnaire $questionnaire): iterable;
}
