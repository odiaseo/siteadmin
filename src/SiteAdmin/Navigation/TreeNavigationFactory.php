<?php
namespace SiteAdmin\Navigation;

use Zend\Navigation\Exception;
use Zend\Navigation\Service\AbstractNavigationFactory;

class TreeNavigationFactory
    extends AbstractNavigationFactory
{
    protected $_serviceManager;
    protected $_service = 'siteadmin\service\menu';


    protected function getName()
    {
        return 'admin_menu';
    }

    protected function getPagesFromConfig($config = null)
    {
        if (is_callable($config)) {
            return $config($this->_serviceManager);
        }
    }

    protected function getPages($serviceManager)
    {
        /** @var $service \SiteAdmin\Service\MenuService */
        $service     = $serviceManager->get($this->_service);
        $menus       = $service->getAdminMenu();
        $this->pages = $this->preparePages($serviceManager, $menus);

        return $this->pages;
    }
}