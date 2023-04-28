<?php

namespace Manual\Builder;

use Manual\Dto\QuestionDto;
use Manual\Entity\Question;

final class QuestionBuilder
{
    /**
     * @param Question $question
     * @return QuestionDto
     */
    public static function buildQuestion(Question $question): QuestionDto
    {
        $questionDto = new QuestionDto($question->getSlug(), $question->getText(), $question->getPosition());
        $options = $question->getOptions();

        foreach ($options as $option) {
            $optionDto = OptionBuilder::buildOption($option);
            $questionDto->addOption($optionDto);
        }

        return $questionDto;
    }
}
