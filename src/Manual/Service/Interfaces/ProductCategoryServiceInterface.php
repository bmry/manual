<?php

namespace Manual\Service\Interfaces;

interface ProductCategoryServiceInterface
{
    public function getProductCategoryBySlug(string $categorySlug);
}
