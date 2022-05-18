<?php

declare(strict_types=1);

namespace App\DataProvider;

interface DataProviderInterface
{

    /**
     * @return mixed
     */
    public function getData(): mixed;
}
