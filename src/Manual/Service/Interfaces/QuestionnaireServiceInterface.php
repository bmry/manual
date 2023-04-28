<?php

namespace Manual\Service\Interfaces;

use Manual\Entity\ProductCategory;
use Manual\Entity\Questionnaire;

interface QuestionnaireServiceInterface
{
    public function getQuestionnaireByProductCategory(ProductCategory $productCategory): Questionnaire;
}
