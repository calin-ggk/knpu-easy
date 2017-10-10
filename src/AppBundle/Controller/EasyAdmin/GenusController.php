<?php

namespace AppBundle\Controller\EasyAdmin;


use AppBundle\Entity\Genus;

class GenusController extends AppAdminController
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