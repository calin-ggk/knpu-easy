<?php

namespace AppBundle\Controller\EasyAdmin;


use AppBundle\Entity\Genus;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController;

class AppAdminController extends AdminController
{
    public function exportAction()
    {
        throw new \RuntimeException('Action for exporting an entity not defined!');
    }
}