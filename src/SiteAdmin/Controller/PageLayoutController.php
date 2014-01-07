<?php
namespace SiteAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class PageLayoutController
    extends AbstractActionController
{
    public function indexAction()
    {
        $gridList = $listItems = array();

        /** @var $gridService \SynergyDataGrid\Service\GridService */
        $gridService = $this->getServiceLocator()->get('synergy\service\grid');

        $entityCacheFile = $gridService->getEntityCacheFile();
        $entities        = include "$entityCacheFile";
        ksort($entities);

        foreach ($entities as $item => $className) {
            if (strpos($item, '-') === false) {
                $gridList[$item] = $this->getServiceLocator()->get('jqgrid')->setGridIdentity(
                    $className, $item, null, false
                );
                $listItems[]     = $item;
            }
        }

        return $return = array(
            'entities' => $listItems,
            'grids'    => $gridList
        );

    }
}