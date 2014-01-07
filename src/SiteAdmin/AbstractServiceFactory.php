<?php
namespace SiteAdmin;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AbstractServiceFactory
    implements AbstractFactoryInterface
{

    protected $_configPrefix;

    public function __construct()
    {
        $this->_configPrefix = 'admin\service\\';
    }

    /**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param                         $name
     * @param                         $requestedName
     *
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        if (substr($requestedName, 0, strlen($this->_configPrefix)) != $this->_configPrefix) {
            return false;
        }

        return true;
    }


    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param                         $name
     * @param                         $requestedName
     *
     * @return mixed|\SynergyCommon\Service\AbstractService
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $serviceId   = str_replace($this->_configPrefix, '', $requestedName);
        $serviceName = __NAMESPACE__ . '\Service\\' . ucfirst($serviceId) . 'Service';

        /** @var $service \SynergyCommon\Service\ApiService */
        $service = new $serviceName();

        /** @var $client \SynergyCommon\Client\HttpRestJsonClient */
        $client = $serviceLocator->get('api\client\json');

        /** @var $logger \SynergyCommon\Util\ErrorHandler */
        $logger = $serviceLocator->get('logger');

        $service->setLogger($logger);
        $service->setClient($client);

        return $service;
    }
}