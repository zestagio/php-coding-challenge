<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\CreatedAtAwareInterface;
use App\Entity\CreatedByAwareInterface;
use App\Entity\UpdatedAtAwareInterface;
use App\Entity\UpdatedByAwareInterface;
use DateTime;
use DateTimeInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Security;

class CreateUpdateEntityListener
{
    private LoggerInterface $logger;
    private Security $security;

    /**
     * @param LoggerInterface $monologLogger
     * @param Security $security
     */
    public function __construct(LoggerInterface $monologLogger, Security $security)
    {
        $this->logger = $monologLogger;
        $this->security = $security;
    }

    /**
     * @param CreatedAtAwareInterface|CreatedByAwareInterface $entity
     */
    public function prePersist(CreatedAtAwareInterface|CreatedByAwareInterface $entity): void
    {
        if (!$this->isApplicable()) {
            return;
        }

        if ($entity instanceof CreatedAtAwareInterface) {
            $entity->setCreatedAt(new DateTime());
        }

        if ($entity instanceof CreatedByAwareInterface && $user = $this->security->getUser()) {
            $entity->setCreatedBy($user);
        }
    }

    /**
     * @param UpdatedAtAwareInterface|UpdatedByAwareInterface $entity
     */
    public function preUpdate(UpdatedAtAwareInterface|UpdatedByAwareInterface $entity): void
    {
        if (!$this->isApplicable()) {
            return;
        }

        $updatedAt = new DateTime();
        $message = 'The entity %s::%d was updated at %s';
        $placeholders = [get_class($entity), $entity->getId(), $updatedAt->format(DateTimeInterface::ATOM)];

        if ($entity instanceof UpdatedAtAwareInterface) {
            $entity->setUpdatedAt($updatedAt);
        }

        if ($user = $this->security->getUser()) {
            $message .= ' by user %s';
            $placeholders[] = $user->getUserIdentifier();

            if ($entity instanceof UpdatedByAwareInterface) {
                $entity->setUpdatedBy($user);
            }
        }

        $this->logger->info(sprintf($message, ...$placeholders));
    }

    /**
     * @return bool
     */
    private function isApplicable(): bool
    {
        return PHP_SAPI !== 'cli';
    }
}
