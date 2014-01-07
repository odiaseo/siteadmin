<?php
namespace SiteAdmin\Service;


use SiteAdmin\Util;
use SynergyCommon\Service\ApiService;
use SynergyDataGrid\Grid\GridType\BaseGrid;

class MenuService
    extends ApiService
{
    public function getAdminMenu()
    {
        $endpoint = '/affiliate/api/merchant';
        $data     = $this->_client->get($endpoint);

        /** @var $menuModel \SiteAdmin\Model\AdminMenu */
        $menuModel = $this->_serviceManager->get('admin\model\adminMenu');
        $menus     = $menuModel->getMenu();

        $entities = $this->_buildEntityTree();
        array_push($menus, $entities);

        return $menus;
    }


    protected function _buildEntityTree()
    {
        $main = array(
            'title'      => 'Tables',
            'label'      => 'Tables',
            'route'      => 'grid',
            'module'     => 'admin',
            'controller' => 'grid',
            'action'     => 'index',
            'resource'   => "mvc:admin:grid",
            'privilege'  => 'index',
            'fragment'   => 'grid',
            'visible'    => 1,
            'level'      => 1,
            'icon'       => 'icom-gridview',
            'pages'      => array()

        );

        $list      = $main;
        $cacheFile = $this->getEntityCacheFile();
        $entities  = include "$cacheFile";
        $section   = array();

        foreach ($entities as $k => $data) {
            if (substr($k, 0, 5) != 'base-') {
                $title     = ucwords(str_replace('-', ' ', $k));
                $section[] = array_merge(
                    $main, array(
                                'title'     => $title,
                                'label'     => $title,
                                'route'     => 'grid',
                                'privilege' => $k,
                                'fragment'  => $k,
                                'icon'      => 'icon-white icon-th',
                           )
                );
            }
        }
        $list['pages'] = $section;

        return $list;
    }

    protected function _buildPage($node)
    {
        $params = array();
        if ($node['parameters']) {
            parse_str($node['parameters'], $params);
        }

        return array(
            'title'    => $node['title'],
            'label'    => $node['title'],
            'route'    => $node['routeName'],
            'resource' => Util::getResourceString($node['routeName'], $node['slug']),
            'fragment' => $node['slug'],
            'visible'  => $node['isVisible'],
            'level'    => $node['level'],
            'icon'     => $node['iconClassName'],
            'params'   => $params
        );
    }

}