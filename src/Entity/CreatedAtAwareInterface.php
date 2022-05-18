<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;

interface CreatedAtAwareInterface
{

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime;

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): self;
}
