<?php
/**
 * This file is part of PMG Notifications plugin
 *
 * Copyright (c) 2015 PMG <http://pmg.com>
 *
 * For full copyright and license information please see the LICENSE
 * file that was distributed with this source code.
 *
 * @category    WordPress
 * @copyright   2015 PMG <http://pmg.com>
 * @license     http://opensource.org/licenses/Apache-2.0 Apache-2.0
 */

namespace PMG\Notifications;

!defined('ABSPATH') && exit;

abstract class Setup
{
    const PAGE_SLUG = 'pmg-notificaiton-settings';

    const PREFIX = 'pmg_notifications_';

    const SETTINGS_SECTION = 'pmg_notifications_settings';

    private static $registry = array();

    public static function instance()
    {
        $cls = get_called_class();
        if (!isset(self::$registry[$cls])) {
            self::$registry[$cls] = new $cls();
        }
        return self::$registry[$cls];
    }

    public static function init()
    {
        static::instance()->hook();
    }

    abstract public function hook();
}
