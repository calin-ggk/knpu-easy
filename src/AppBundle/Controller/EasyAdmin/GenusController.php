<?php

namespace AppBundle\Controller\EasyAdmin;


use AppBundle\Entity\Genus;
use AppBundle\Service\CsvExporter;

class GenusController extends AppAdminController
{
    private $csvExporter;

    public function __construct(CsvExporter $csvExporter)
    {
        $this->csvExporter = $csvExporter;
    }

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

    public function exportAction()
    {
        $sortDirection = $this->request->query->get('sortDirection');
        if (empty($sortDirection) || !in_array(strtoupper($sortDirection), ['ASC', 'DESC'])) {
            $sortDirection = 'DESC';
        }

        $sortField = $this->request->query->get('sortField');
        $dqlFilter = $this->entity['list']['dql_filter'];
        $queryBuilder = $this->createListQueryBuilder($this->entity['class'], $sortDirection, $sortField, $dqlFilter);

        return $this->csvExporter->getResponseFromQueryBuilder($queryBuilder, $this->entity['class'],
            $this->entity['class'] . '.csv');
    }
}