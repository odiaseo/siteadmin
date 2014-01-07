<?php

namespace SiteAdmin\Model;

use SynergyCommon\Model\AbstractModel;

class BaseModel
    extends AbstractModel
{

    protected $_identity;

    protected $_acl;

    protected $_apiClient;

    public function setAcl($acl)
    {
        $this->_acl = $acl;
    }

    public function getAcl()
    {
        return $this->_acl;
    }

    public function setIdentity($identity)
    {
        $this->_identity = $identity;
    }

    public function getIdentity()
    {
        return $this->_identity;
    }

    public function setApiClient($apiClient)
    {
        $this->_apiClient = $apiClient;
    }

    public function getApiClient()
    {
        return $this->_apiClient;
    }

}