<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace SiteAdmin;

use Monolog\Handler\RotatingFileHandler;
use SynergyCommon\Client\ClientOptions;
use SynergyCommon\Client\HttpRestJsonClient;
use SynergyCommon\Service\ApiService;
use SynergyCommon\Util\ErrorHandler;
use Zend\Http\Client as HttpClient;
use Zend\Http\Request;
use Zend\Mvc\ModuleRouteListener;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';

    }

    public function getServiceConfig()
    {
        return array(
            'invokables'         => array(
                __NAMESPACE__ . '\Service\MenuService' => __NAMESPACE__ . '\Service\MenuService',
            ),
            'abstract_factories' => array(
                __NAMESPACE__ . '\AbstractModelFactory',
                __NAMESPACE__ . '\AbstractServiceFactory',
            ),
            'aliases'            => array(
                'admin_menu' => __NAMESPACE__ . '\Navigation\TreeNavigationFactory'
            ),
            'factories'          => array(
                __NAMESPACE__ . '\NavigationFactory'                => __NAMESPACE__ . '\NavigationFactory',
                __NAMESPACE__ . '\Navigation\TreeNavigationFactory' =>
                __NAMESPACE__ . '\Navigation\TreeNavigationFactory',

                'api\client\json'                                   => function ($serviceManager) {
                    /** @var $serviceManager \Zend\ServiceManager\ServiceManager */

                    /** @var $httpClient \Zend\Http\Client */
                    $httpClient = $serviceManager->get('HttpClient');

                    $request            = new Request();
                    $httpRestJsonClient = new HttpRestJsonClient($httpClient, $request);

                    $config  = $serviceManager->get('config');
                    $options = new ClientOptions($config['synergy']['api']);
                    $httpRestJsonClient->setOptions($options);

                    return $httpRestJsonClient;
                },
                'HttpClient'                                        => function () {
                    $httpClient = new HttpClient();
                    # use curl adapter as standard has problems with ssl
                    $httpClient->setAdapter('Zend\Http\Client\Adapter\Curl');

                    return $httpClient;
                },

                'client\service\api'                                => function ($serviceManager) {
                    /** @var $serviceManager \Zend\ServiceManager\ServiceManager */

                    /** @var $client \SynergyCommon\Client\HttpRestJsonClient */
                    $client = $serviceManager->get('api\client\json');

                    /** @var $logger \SynergyCommon\Util\ErrorHandler */
                    $logger = $serviceManager->get('logger');

                    $service = new ApiService();
                    $service->setLogger($logger);
                    $service->setClient($client);

                    return $service;
                },
                'logger'                                            => function () {
                    $filename = __DIR__ . '/../../data/logs/app.log';
                    $stream   = new RotatingFileHandler($filename, 5);
                    $logger   = new ErrorHandler(__NAMESPACE__, array($stream));

                    return $logger;
                },
            ),
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
