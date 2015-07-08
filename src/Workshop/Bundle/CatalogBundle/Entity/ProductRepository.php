<?php

namespace Workshop\Bundle\CatalogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends EntityRepository
{
    public function findProductName($limit)
    {
        $query = $this->getEntityManager()->createQuery(
            '
            SELECT p,c FROM  WorkshopCatalogBundle:Product p JOIN p.catalog c
            WHERE EXISTS

            (SELECT p1
            FROM   WorkshopCatalogBundle:Product p1
            Where p1.catalog=p.catalog
            GROUP BY p1.catalog
            HAVING COUNT(p1.catalog)>1
            )
'
        )
            ->setMaxResults($limit);

        return $query->getArrayResult();
    }
}
