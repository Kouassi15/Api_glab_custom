<?php

namespace App\Repository;

use App\Entity\NiveauScolaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NiveauScolaire>
 *
 * @method NiveauScolaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiveauScolaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiveauScolaire[]    findAll()
 * @method NiveauScolaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiveauScolaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiveauScolaire::class);
    }

//    /**
//     * @return NiveauScolaire[] Returns an array of NiveauScolaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NiveauScolaire
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
