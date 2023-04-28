<?php

namespace Manual\Builder;

use Manual\Dto\OptionDto;
use Manual\Entity\Option;

final class OptionBuilder
{
    /**
     * @param Option $option
     * @return OptionDto
     */
    public static function buildOption(Option $option): OptionDto
    {
        $optionDTO = new OptionDto($option->getSlug(), $option->getText());

        foreach ($option->getOptionQuestions() as $optionQuestion) {
            $optionDTO->addQuestions(QuestionBuilder::buildQuestion($optionQuestion->getQuestion()));
        }

        return $optionDTO;
    }
}
