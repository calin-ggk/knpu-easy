<?php

namespace AppBundle\Event;

use AppBundle\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $tokenStorage;
    private $authorizationChecker;

    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationChecker $authorizationChecker)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
    }

    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::PRE_UPDATE => 'onPreUpdate',
            EasyAdminEvents::PRE_EDIT => 'onPreEdit',
        ];
    }

    public function onPreUpdate(GenericEvent $event)
    {
        $e = $event->getSubject();
        if ($e instanceof User) {
            $user = $this->tokenStorage->getToken()->getUser();
            if (!$user instanceof User) {
                $user = null;
            }
            $e->setLastUpdatedBy($user);
        }
    }

    public function onPreEdit(GenericEvent $event)
    {
        $subject = $event->getSubject();
        if ($subject['class'] == User::class) {
            $this->denyAccessUnlessSuperAdmin();
        }
    }

    private function denyAccessUnlessSuperAdmin()
    {
        if (!$this->authorizationChecker->isGranted('ROLE_SUPERADMIN')) {
            throw new AccessDeniedException();
        }
    }
}