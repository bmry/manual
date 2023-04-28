<?php

namespace Manual\Service;

use App\Repository\ProductCategoryRepository;
use Manual\Entity\ProductCategory;
use Manual\Service\Interfaces\ProductCategoryServiceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductCategoryService implements ProductCategoryServiceInterface
{
    public function __construct(
        private ProductCategoryRepository $productCategoryRepository
    ) {
    }

    public function getProductCategoryBySlug(string $categorySlug)
    {
        $productCategory = $this->productCategoryRepository->findOneBy([
            'slug' => $categorySlug,
        ]);

        if ($productCategory instanceof ProductCategory) {
            throw new NotFoundHttpException("Product Category: $categorySlug is not found");
        }

        return $productCategory;
    }

    public function getProductCategoryById(int $categoryId)
    {
        $productCategory = $this->productCategoryRepository->findOneBy([
            'id' => $categoryId,
        ]);

        if (! $productCategory instanceof ProductCategory) {
            throw new NotFoundHttpException("Product Category: $categoryId is not found");
        }

        return $productCategory;
    }
}
