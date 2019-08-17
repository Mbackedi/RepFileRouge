<?php

namespace App\Repository;

use App\Entity\Envoyeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Envoyeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Envoyeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Envoyeur[]    findAll()
 * @method Envoyeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnvoyeurRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Envoyeur::class);
    }

    // /**
    //  * @return Envoyeur[] Returns an array of Envoyeur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Envoyeur
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
