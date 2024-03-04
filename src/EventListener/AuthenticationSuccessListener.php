<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Sonata\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

class AuthenticationSuccessListener
{
    public function __construct(private RoleHierarchyInterface $roleHierarchy)
    {
    }

    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        $data['data'] = array(
            'id' => $user->getId(),
            'username' => $user->getUserIdentifier(),
            'email' => $user->getEmail(),
            'role' => $this->roleHierarchy->getReachableRoleNames($user->getRealRoles()),
        );

        $event->setData($data);
    }
}
