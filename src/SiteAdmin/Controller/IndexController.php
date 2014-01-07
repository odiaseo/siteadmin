<?php
namespace SiteAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class IndexController
    extends AbstractActionController
{
    public function indexAction()
    {
        $total = 20;
        return array(
            'merchants' => $total
        );
    }
}