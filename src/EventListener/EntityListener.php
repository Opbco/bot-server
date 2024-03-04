<?php

namespace App\EventListener;

use App\Entity\Document;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreRemoveEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\Security\Core\Security;

class EntityListener
{

    public function __construct(private Security $security)
    {
    }

    public function prePersist(PrePersistEventArgs $args)
    {
        $entity = $args->getObject();

        if (property_exists($entity, 'user_created') && $entity->getUserCreated() === null) {
            $user = $this->security->getUser();
            $entity->setUserCreated($user);
        }

        if (property_exists($entity, 'date_created') && $entity->getDateCreated() === null) {
            $entity->setDateCreated(new \DateTimeImmutable());
        }
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();

        if (property_exists($entity, 'user_updated') && $entity->getUserUpdated() === null) {
            $user = $this->security->getUser();
            $entity->setUserUpdated($user);
        }

        if (property_exists($entity, 'date_updated') && $entity->getDateUpdated() === null) {
            $entity->setDateUpdated(new \DateTimeImmutable());
        }
    }

    public function PreRemove(PreRemoveEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof Document) {
            return;
        }

        if(file_exists($entity->getFileAbsolutePath())){
            unlink($entity->getFileAbsolutePath());
        }
    }
}
