<?php

namespace Manual\Service;

use App\Repository\OptionQuestionRepository;
use Manual\Entity\Questionnaire;
use Manual\Service\Interfaces\OptionQuestionServiceInterface;

class OptionQuestionService implements OptionQuestionServiceInterface
{
    public function __construct(
        private OptionQuestionRepository $optionQuestionRepository
    ) {
    }

    public function getOptionalQuestionsByQuestionnaire(Questionnaire $questionnaire): iterable
    {
        return $this->optionQuestionRepository->getOptionalQuestionByQuestionaire($questionnaire);
    }
}
