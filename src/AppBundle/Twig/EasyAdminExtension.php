<?php
/**
 * Created by PhpStorm.
 * User: calin
 * Date: 08/10/2017
 * Time: 12:40
 */

namespace AppBundle\Twig;


use AppBundle\Entity\Genus;

class EasyAdminExtension extends \Twig_Extension
{
    public function getFilters()
    {
        $filters = [
            new \Twig_SimpleFilter('filter_admin_actions', [$this, 'filterActions'])
        ];
        return $filters;
    }

    public function filterActions(array $itemActions, $item)
    {
        if ($item instanceof Genus && $item->getIsPublished()) {
            unset($itemActions['delete']);
        }
        return $itemActions;
    }
}