<?php
namespace Admin\Model;

use Admin\Util;
use Doctrine\ORM\AbstractQuery;

class AdminMenu
    extends BaseModel
{
    public function getMenu()
    {
        /** @var $repo \Gedmo\Tree\Entity\Repository\NestedTreeRepository */
        $repo     = $this->getRepository(); //  $em->getRepository($navService->getEntity());
        $rootMenu = $this->getRootMenu();
        $menus    = $repo->getNodesHierarchy($rootMenu);

        $pages = $this->toHierarchy($menus);

        return $pages;
    }

    public function getRootMenu()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        /** @var $query \Doctrine\ORM\Query */

        $query = $qb->select($this->getAlias())
            ->from($this->getEntity(), $this->getAlias())
            ->where($qb->expr()->eq('e.level', ':level'))
            ->setMaxResults(1)
            ->setParameter('level', 0)
            ->getQuery();

        return $query->getOneOrNullResult(AbstractQuery::HYDRATE_OBJECT);
    }

    public function toHierarchy($collection, $childKey = 'pages')
    {
        // Trees mapped
        $hasIdentity = $this->getIdentity() ? true : false;
        $trees       = array();
        //$l = 0;
        if (count($collection) > 0) {
            // Node Stack. Used to help building the hierarchy
            $stack = array();
            foreach ($collection as $node) {
                $item            = $this->_buildPage($node, $hasIdentity);
                $item[$childKey] = array();
                // Number of stack items
                $l = count($stack);
                // Check if we're dealing with different levels
                while ($l > 0 && $stack[$l - 1]['level'] >= $item['level']) {
                    array_pop($stack);
                    $l--;
                }
                // Stack is empty (we are inspecting the root)
                if ($l == 0) {
                    // Assigning the root node
                    $i         = count($trees);
                    $trees[$i] = $item;
                    $stack[]   = & $trees[$i];
                } else {
                    // Add node to parent
                    $i                            = count($stack[$l - 1][$childKey]);
                    $stack[$l - 1][$childKey][$i] = $item;
                    $stack[]                      = & $stack[$l - 1][$childKey][$i];
                }
            }
        }

        return $trees;
    }

    protected function _buildPage($node, $hasIdentity = false)
    {
        $params = array();
        if ($node['parameters']) {
            parse_str($node['parameters'], $params);
        }

        if (in_array($node['slug'], array('login', 'logout'))) {
            if ($node['slug'] == 'login') {
                $node['isVisible'] = !$hasIdentity;
            } elseif ($node['slug'] == 'logout') {
                $node['isVisible'] = $hasIdentity;
            }
        }


        $menu = array(
            'id'        => $node['id'],
            'title'     => $node['title'],
            'label'     => $node['title'],
            'route'     => $node['routeName'],
            'resource'  => Util::getResourceString($node['routeName'], $node['slug']),
            'privilege' => $node['slug'],
            'fragment'  => $node['slug'],
            'visible'   => $node['isVisible'],
            'level'     => $node['level'],
            'icon'      => $node['iconClassName'],
            'params'    => $params
        );


        if (!empty($node['uri'])) {
            $menu['uri']    = $node['uri'];
            $menu['target'] = '_blank';
            unset($menu['route']);
        }

        return $menu;
    }
}