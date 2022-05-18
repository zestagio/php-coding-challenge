<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;

interface UpdatedAtAwareInterface
{

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime;

    /**
     * @param DateTime|null $updatedAt
     */
    public function setUpdatedAt(?DateTime $updatedAt = null): self;
}
