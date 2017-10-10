<?php

namespace AppBundle\Controller\EasyAdmin;


use AppBundle\Entity\Genus;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController;

class AppAdminController extends AdminController
{
    public function changePublishedStatusAction()
    {
        $id = $this->request->query->get('id');
        $e = $this->em->find(Genus::class, $id);
        $e->setIsPublished(!$e->getIsPublished());
        $this->em->flush();
        $this->addFlash('success', sprintf('Genus %s published!', $e->getIsPublished() ? '' : 'un'));

        return $this->redirectToRoute('easyadmin', [
            'action' => 'show',
            'entity' => $this->request->query->get('entity'),
            'id' => $id
        ]);
    }
}