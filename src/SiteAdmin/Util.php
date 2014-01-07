<?php
namespace SiteAdmin;

use AffiliateManager\Util as Utility;

class Util
    extends Utility
{
    public static function getResourceString($routeName, $uniqueId)
    {
        return 'mvc:' . strtolower($routeName) . '.' . strtolower($uniqueId);
    }
}