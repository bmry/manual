<?php

namespace Manual\Service\Interfaces;

use Manual\Entity\ProductCategory;

interface RecommenderServiceInterface
{
    public function getRecommendationFromCategoryBasedOnQuestionnaire(string $submittedQuestionnaire, ProductCategory $productCategory): array;
}
