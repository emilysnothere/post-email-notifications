<?php
/**
 * This file is part of PMG Notifications Plugin
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

use PMG\Notifications as N;

function pmg_notifications_load()
{
    if (is_admin()) {
        N\DisplayNotificationsSettings::init();
        N\RegisterNotificationsSettings::init();
        N\SendNotificationEmails::init();
    }
}
