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

class DisplayNotificationsSettings extends Setup
{
    public function hook()
    {
        add_action('admin_menu', array($this, 'emailNotificationsSettings'));
    }

    public function emailNotificationsSettings()
    {
        add_options_page(
            __('Email Notifications Settings', 'pmg'),
            __('Email Notifications', 'pmg'),
            'manage_options',
            self::PAGE_SLUG,
            array($this, 'displaySettingOptions')
        );
    }

    public function displaySettingOptions()
    {
        ?>
        <div class="wrap">
            <h2><?php _e('Email Notifications Settings', 'pmg'); ?></h2>
            <form method="post" action="options.php">
                <table class="form-table">
                    <?php
                    settings_fields(self::PAGE_SLUG);
                    do_settings_sections(self::PAGE_SLUG);
                    ?>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}
