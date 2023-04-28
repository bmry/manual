<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Manual\Entity\Option;
use Manual\Entity\OptionExcludedProduct;

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

     public function getOptionExcludedProductSlug(Option $option): array
     {
         return $this->createQueryBuilder('oep')
             ->select('p.slug')
             ->leftJoin('Manual\Entity\Product', 'p', "WITH", 'oep.product = p.id')
             ->where('oep.option = :option')
             ->setParameter('option', $option)
             ->getQuery()
             ->getResult(Query::HYDRATE_SCALAR_COLUMN)
         ;
     }
}
