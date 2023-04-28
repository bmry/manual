<?php

namespace Manual\Service;

use App\Repository\QuestionRepository;
use Manual\Entity\Questionnaire;
use Manual\Service\Interfaces\OptionQuestionServiceInterface;
use Manual\Service\Interfaces\QuestionServiceInterface;

class QuestionService implements QuestionServiceInterface
{
    /**
     * @param QuestionRepository $questionRepository
     * @param OptionQuestionServiceInterface $optionQuestionService
     */
    public function __construct(
        private QuestionRepository $questionRepository,
        private OptionQuestionServiceInterface $optionQuestionService
    ) {
    }

    /**
     * @param Questionnaire $questionnaire
     * @return iterable
     */
    public function getQuestionsByQuestionnaire(Questionnaire $questionnaire): iterable
    {
        $optionalQuestionIdList = $this->optionQuestionService->getOptionalQuestionsByQuestionnaire($questionnaire);
        return $this->questionRepository->getMainQuestionsByQuestionnaire($questionnaire, $optionalQuestionIdList);
    }
}
