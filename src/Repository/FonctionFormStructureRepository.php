<?php

namespace App\Repository;

use App\Entity\FonctionFormStructure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FonctionFormStructure>
 *
 * @method FonctionFormStructure|null find($id, $lockMode = null, $lockVersion = null)
 * @method FonctionFormStructure|null findOneBy(array $criteria, array $orderBy = null)
 * @method FonctionFormStructure[]    findAll()
 * @method FonctionFormStructure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FonctionFormStructureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FonctionFormStructure::class);
    }

    public function save(FonctionFormStructure $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FonctionFormStructure $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FonctionFormStructure[] Returns an array of FonctionFormStructure objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FonctionFormStructure
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
