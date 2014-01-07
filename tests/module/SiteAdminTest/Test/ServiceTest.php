<?php
namespace SiteAdminTest\Test;


use SiteAdminTest\BaseTestClass;

/**
 * @backupGlobals disabled
 */
class ServiceTest extends BaseTestClass
{
    const TEST_MERCHANT_ID = 313;

    public function testService()
    {
        /** @var $service \SiteAdmin\Service\MenuService */
        $service = $this->_serviceManager->get('siteadmin\service\menu');
        $this->assertInstanceOf('SiteAdmin\Service\MenuService', $service);
    }

    public function testModel()
    {
        /** @var $menuModel \SiteAdmin\Model\AdminMenuModel */
        $menuModel = $this->_serviceManager->get('siteadmin\model\adminMenu');
        $this->assertInstanceOf('SiteAdmin\Model\AdminMenuModel', $menuModel);
    }
}