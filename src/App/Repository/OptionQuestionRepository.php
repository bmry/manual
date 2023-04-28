<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Manual\Entity\OptionQuestion;
use Manual\Entity\Questionnaire;

/**
 * @extends ServiceEntityRepository<OptionQuestion>
 *
 * @method OptionQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method OptionQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method OptionQuestion[]    findAll()
 * @method OptionQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OptionQuestion::class);
    }

    public function add(OptionQuestion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OptionQuestion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * This retrieve questions that depends on options.
     *
     * @param Questionnaire $questionnaire
     */
    public function getOptionalQuestionByQuestionaire(Questionnaire $questionnaire): iterable
    {
        $qb = $this->createQueryBuilder('oq');
        return $qb->select('q.id')
            ->leftJoin('Manual\Entity\Question', 'q', "WITH", 'oq.question = q.id')
            ->leftJoin('Manual\Entity\Questionnaire', 'qn', "WITH", 'q.questionnaire = qn.id')
            ->where('q.questionnaire = :questionnaire')
            ->setParameter('questionnaire', $questionnaire)
            ->getQuery()
            ->getResult(Query::HYDRATE_SCALAR_COLUMN);
    }
}
