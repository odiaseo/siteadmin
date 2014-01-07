<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'controllers'    => array(
        'invokables' => array(
            'SiteAdmin\Controller\Index'      => 'SiteAdmin\Controller\IndexController',
            'SiteAdmin\Controller\PageLayout' => 'SiteAdmin\Controller\PageLayoutController',
        ),
    ),
    'router'         => array(
        'routes' => array(
            'admin'       => array(
                'type'          => 'Literal',
                'options'       => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SiteAdmin\Controller',
                        'module'        => 'SiteAdmin',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'       => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults'    => array(
                                'controller' => 'index',
                                'module'     => 'admin',
                                'action'     => 'index'
                            ),
                        )
                    )
                ),
            ),

            'page\layout' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/admin/page/layout',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SiteAdmin\Controller',
                        'module'        => 'admin',
                        'controller'    => 'PageLayout',
                        'action'        => 'index'
                    ),
                ),
            ),

        ),
    ),


    'view_manager'   => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'template_map'             => include __DIR__ . '/../template_map.php',
        'template_path_stack'      => array(
            __DIR__ . '/../view',
        ),
        'strategies'               => array(
            'ViewJsonStrategy',
        ),
    ),

    'module_layouts' => array(
        'SiteAdmin' => 'layout/virgo',
    ),
    'doctrine'       => array(

        'driver' => array(
            'am\entity\siteadmin'          => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/SiteAdmin/Entity')
            ),
            'synergy\common\entities'      => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array('vendor/synergy/common/lib/SynergyCommon/Entity')
            ),
            'translatable\metadata\driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    'vendor/gedmo/doctrine-extensions/lib/Gedmo/Translatable/Entity',
                ),
            ),
            'orm_default'                  => array(
                'class'   => 'Doctrine\ORM\Mapping\Driver\DriverChain',
                'drivers' => array(
                    'SiteAdmin\Entity'          => 'am\entity\siteadmin',
                    'Gedmo\Translatable\Entity' => 'translatable\metadata\driver',
                    'SynergyCommon\Entity'      => 'synergy\common\entities',
                )
            )
        ),
    ),
    'synergy'        => array(
        'api' => array(
            'domain'  => 'http://affiliate-manager.com/',
            'headers' => array(
                'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'Accept'       => 'application/json'
            )
        )
    ),
);
