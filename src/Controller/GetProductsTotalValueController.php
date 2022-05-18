<?php

declare(strict_types=1);

namespace App\Controller;

use App\DataProvider\DataProviderInterface;
use App\DTO\ProductsTotalValue;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetProductsTotalValueController extends AbstractController
{
    private DataProviderInterface $dataProvider;

    /**
     * @param DataProviderInterface $productsTotalValueDataProvider
     */
    public function __construct(DataProviderInterface $productsTotalValueDataProvider)
    {
        $this->dataProvider = $productsTotalValueDataProvider;
    }

    public function __invoke(): JsonResponse
    {
        return $this->json((new ProductsTotalValue())->setValue($this->dataProvider->getData()));
    }
}
