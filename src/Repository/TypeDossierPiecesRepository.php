<?php

namespace App\Repository;

use App\Entity\TypeDossierPieces;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeDocumentPieces>
 *
 * @method TypeDossierPieces|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeDossierPieces|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeDossierPieces[]    findAll()
 * @method TypeDossierPieces[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeDossierPiecesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeDossierPieces::class);
    }

    public function save(TypeDossierPieces $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TypeDossierPieces $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TypeDossierPieces[] Returns an array of TypeDossierPieces objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypeDossierPieces
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
