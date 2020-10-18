<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getQuery(): Query
    {
        $dql = 'SELECT p from App\Entity\Product p';

        return $this->getEntityManager()->createQuery($dql);
    }

    /**
     * @param string $term
     * @return Product[]|null
     */
    public function findByTerm(string $term): ?array
    {
        return $this->createQueryBuilder('p')
            ->select('p.id', 'CONCAT(p.reference, \' - \',  p.name) as text')
            ->where('p.reference = :term')
            ->orWhere('p.id = :term')
            ->setParameter('term', $term)
            ->getQuery()
            ->getResult();
    }
}
