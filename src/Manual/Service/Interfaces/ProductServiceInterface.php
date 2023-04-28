<?php

namespace Manual\Service\Interfaces;

use Manual\Entity\Product;
use Manual\Entity\ProductCategory;

interface ProductServiceInterface
{
    public function getProductSlugListByCategory(ProductCategory $productCategory): array;

    public function getProductBySlug(string $productSlug): Product;
}
