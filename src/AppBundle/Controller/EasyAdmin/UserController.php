<?php

namespace AppBundle\Controller\EasyAdmin;


use AppBundle\Entity\User;

class UserController extends AppAdminController
{
    /**
     * @param User $entity
     */
    public function preUpdateEntity($entity)
    {
        $entity->setUpdatedAt(new \DateTime());
    }
}