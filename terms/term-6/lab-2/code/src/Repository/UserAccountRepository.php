<?php

namespace App\Repository;

use App\Entity\UserAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserAccount>
 *
 * @method UserAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAccount[]    findAll()
 * @method UserAccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAccount::class);
    }

       /**
        * @return UserAccount Returns UserAccount
        */
       public function findByUsernamePassword(string $username, string $password): UserAccount
       {
           return $this->createQueryBuilder('u')
               ->andWhere('u.username = :username')
               ->andWhere('u.password = :password')
               ->setParameter('username', $username)
               ->setParameter('password', $password)
               ->getQuery()
               ->getOneOrNullResult()
           ;
       }

    //    public function findOneBySomeField($value): ?UserAccount
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
