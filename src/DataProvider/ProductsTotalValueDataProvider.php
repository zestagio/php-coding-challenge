<?php

declare(strict_types=1);

namespace App\DataProvider;

use App\Entity\Product;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

class ProductsTotalValueDataProvider implements DataProviderInterface
{
    private ManagerRegistry $registry;

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritDoc}
     *
     * @throws NonUniqueResultException
     */
    public function getData(): int
    {
        $result = $this
            ->registry
            ->getRepository(Product::class)
            ->createQueryBuilder('p')
            ->select('SUM(p.quantity) as totalValue')
            ->getQuery()
            ->getOneOrNullResult();

        return (int) ($result['totalValue'] ?? 0);
    }
}
