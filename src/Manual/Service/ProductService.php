<?php

namespace Manual\Service;

use App\Repository\ProductRepository;
use Manual\Entity\Product;
use Manual\Entity\ProductCategory;
use Manual\Exception\NotFoundException;
use Manual\Service\Interfaces\ProductServiceInterface;

class ProductService implements ProductServiceInterface
{
    public function __construct(
        private ProductRepository $productRepository
    ) {
    }

    /**
     * Returns identifier/slug of products in a given product category
     *
     * @param ProductCategory $productCategory
     */
    public function getProductSlugListByCategory(ProductCategory $productCategory): array
    {
        return $this->productRepository->getProductSlugByCategory($productCategory);
    }

    public function getProductBySlug(string $productSlug): Product
    {
        $product = $this->productRepository->findOneBy([
            'slug' => $productSlug,
        ]);

        if (! $product instanceof Product) {
            throw new NotFoundException("Product ID: $productSlug does not exist");
        }

        return $product;
    }
}
