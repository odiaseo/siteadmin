<?php
namespace SiteAdmin;


use SynergyCommon\Exception\InvalidEntityException;
use Zend\Log\Formatter\Base;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AbstractModelFactory
    implements AbstractFactoryInterface
{

    protected $_configPrefix;

    public function __construct()
    {
        $this->_configPrefix = 'admin\model\\';
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
     * @return \SynergyCommon\Model\AbstractModel
     * @throws InvalidEntityException
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $modelId   = str_replace($this->_configPrefix, '', $requestedName);
        $modelName = __NAMESPACE__ . '\Model\\' . ucfirst($modelId);

        /** @var $model \Admin\Model\BaseModel */
        $model = new $modelName();

        $entityClassname = __NAMESPACE__ . '\Entity\\' . ucfirst($modelId);

        $model->setEntity($entityClassname);
        $model->setEntityKey($modelId);

        $logger = $serviceLocator->get('logger');
        $model->setLogger($logger);

        $model->setEntityManager($serviceLocator->get('doctrine.entitymanager.' . $model->getOrm()));

        $apiClient = $serviceLocator->get('vaboose\service\api');
        //todo get actual vallues

        /** @var $authService \Zend\Authentication\AuthenticationService */
        $authService = $serviceLocator->get('zfcuser_auth_service');
        $identity    = $authService->hasIdentity() ? $authService->getIdentity() : null;

        //        $model->setAcl($acl);
        $model->setIdentity($identity);
        $model->setApiClient($apiClient);

        return $model;
    }
}