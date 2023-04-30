<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Manual\Entity\Option;
use Manual\Entity\OptionExcludedProduct;
use Manual\Entity\Product;

/**
 * @extends ServiceEntityRepository<OptionExcludedProduct>
 *
 * @method OptionExcludedProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method OptionExcludedProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method OptionExcludedProduct[]    findAll()
 * @method OptionExcludedProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionExcludedProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OptionExcludedProduct::class);
    }

    public function save(OptionExcludedProduct $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OptionExcludedProduct $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Get products and products of product excluded by a given option.
     *
     * @param Option $option
     * @return array
     */
     public function getOptionExcludedProductSlug(Option $option): array
     {
         $excludedProductList = [];
         $options = $this->findBy([
             'optionId' => $option,
         ]);
         foreach ($options as $option) {
             $product = $option->getProduct();

             //Skip if a product's parent has been processed.
             if (in_array($product->getSlug(), $excludedProductList)) {
                 continue;
             }

             if ($product->isParent()) {
                 foreach ($product->getChildProducts() as $childProduct) {
                     $excludedProductList[] = $childProduct->getSlug();
                 }
             } else {
                 $excludedProductList[] = $product->getSlug();
             }
         }

         return $excludedProductList;
     }
}
