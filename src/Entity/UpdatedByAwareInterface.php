<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

interface UpdatedByAwareInterface
{

    /**
     * @return UserInterface|null
     */
    public function getUpdatedBy(): ?UserInterface;

    /**
     * @param UserInterface|null $updatedBy
     *
     * @return $this
     */
    public function setUpdatedBy(?UserInterface $updatedBy = null): self;
}
