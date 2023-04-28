<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Manual\Entity\Question;
use Manual\Entity\Questionnaire;

/**
 * @extends ServiceEntityRepository<Question>
 *
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    public function add(Question $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Question $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getMainQuestionsByQuestionnaire(Questionnaire $questionnaire, $optionalQuestionIdList)
    {
        $qb = $this->createQueryBuilder('q');
        return $qb->select()
            ->innerJoin('Manual\Entity\Questionnaire', 'qn')
            ->where('q.questionnaire = :questionnaire')
            ->andWhere($qb->expr()->notIn('q.id', $optionalQuestionIdList))
            ->addOrderBy('q.position', 'ASC')
            ->setParameter('questionnaire', $questionnaire)
            ->getQuery()
            ->getResult();
    }
}
