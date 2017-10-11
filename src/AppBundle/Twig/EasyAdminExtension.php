<?php
/**
 * Created by PhpStorm.
 * User: calin
 * Date: 08/10/2017
 * Time: 12:40
 */

namespace AppBundle\Twig;


use AppBundle\Entity\Genus;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class EasyAdminExtension extends \Twig_Extension
{
    private $authorizationChecker;

    public function __construct(AuthorizationChecker $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

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

        if ($item instanceof User && !$this->authorizationChecker->isGranted('ROLE_SUPERADMIN')) {
            unset($itemActions['edit']);
        }

        unset($itemActions['export']);

        return $itemActions;
    }
}