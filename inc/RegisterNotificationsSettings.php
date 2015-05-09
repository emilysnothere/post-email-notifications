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

class RegisterNotificationsSettings extends Setup
{
    public function hook()
    {
        add_action('admin_init', array($this, 'registerSettings'));
        add_action('admin_init', array($this, 'registerSettingsSection'));
        add_action('admin_init', array($this, 'registerSettingsFields'));
    }

    public function registerSettings()
    {
        register_setting(
            self::PAGE_SLUG,
            self::PREFIX.'settings'
        );
    }

    public function registerSettingsSection()
    {
        add_settings_section(
            self::SETTINGS_SECTION,
            __('Notification Email Settings', 'pmg'),
            false,
            self::PAGE_SLUG
        );
    }

    public function registerSettingsFields()
    {
        $fields = array(
            self::PREFIX.'pending_recipients'    => __('Pending Post Recipients', 'pmg'),
            self::PREFIX.'published_recipients'  => __('Published Post Recipients', 'pmg')
        );

        foreach ($fields as $key => $label) {
            add_settings_field(
                self::PREFIX.$key,
                $label,
                array($this, 'buildInput'),
                self::PAGE_SLUG,
                self::SETTINGS_SECTION,
                array('key' => $key)
            );
        }
    }

    public function buildInput($args)
    {
        $option = get_option(self::SETTINGS_SECTION, array());
        $value = isset($option[$args['key']]) ? $option[$args['key']] : '';

        printf(
            '<input type="text" class="regular-text" id="%1$s[%2$s]" name="%1$s[%2$s]" value="%3$s"',
            esc_attr(self::SETTINGS_SECTION),
            esc_attr($args['key']),
            esc_attr($value)
        );
    }
}
