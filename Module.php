<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace SiteAdmin;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';

    }

    public function getServiceConfig()
    {
        return array(
            'factories'          => array(
                __NAMESPACE__ . '\NavigationFactory'                => __NAMESPACE__ . '\NavigationFactory',
                __NAMESPACE__ . '\Navigation\TreeNavigationFactory' =>
                __NAMESPACE__ . '\Navigation\TreeNavigationFactory',

            ),
            'aliases'            => array(
                'admin_menu' => __NAMESPACE__ . '\Navigation\TreeNavigationFactory'
            ),
            'invokables'         => array(
                __NAMESPACE__ . '\Service\MenuService' => __NAMESPACE__ . '\Service\MenuService',
            ),
            'abstract_factories' => array(
                __NAMESPACE__ . '\AbstractModelFactory',
                __NAMESPACE__ . '\AbstractServiceFactory',
            )
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
