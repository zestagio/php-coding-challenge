<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

interface CreatedByAwareInterface
{

    /**
     * @return UserInterface|null
     */
    public function getCreatedBy(): ?UserInterface;

    /**
     * @param UserInterface $createdBy
     *
     * @return $this
     */
    public function setCreatedBy(UserInterface $createdBy): self;
}
