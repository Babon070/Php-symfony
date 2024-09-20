<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

        /**
         * @return Product[] Returns an array of Product objects
         */
        public function findByExampleField($userId): array
        {

            return $this->createQueryBuilder('p')
                ->select(
                    'p.id',
                    'p.title',
                    'p.description',
                    'pc.name as categoryName',
                    'pi.id as imageId',
                    'u.email',

                )
                ->leftJoin('p.category', 'pc')
                ->innerJoin('p.image', 'pi')
                ->join(User::class, 'u')
                ->andWhere('u.id = :val')
                ->setParameter('val', $userId)
                ->orderBy('p.id', 'DESC')
                ->setMaxResults(2)
                ->getQuery()
                ->getResult()
            ;
        }

        public function findByOneProductField($value): ?Product
        {
            return $this->createQueryBuilder('p')
                ->andWhere('p.title = :val')
                ->setParameter('val', '%' .  $value . '%')
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }

}
