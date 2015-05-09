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

class SendNotificationEmails extends Setup
{
    public function hook()
    {
        add_action('transition_post_status', array($this, 'triggerNotificationEmail'), 10, 3);
    }

    public function triggerNotificationEmail($newStatus, $oldStatus, $post)
    {
        if ($post->post_type != 'post') {
            return;
        }

        if ($newStatus == $oldStatus) {
            return;
        }

        if ($newStatus == 'pending' && $this->getOption('pending_recipients')) {
            $this->sendPendingEmail($post);
        } else if ($newStatus == 'publish' && $this->getOption('published_recipients')) {
            $this->sendPublishEmail($post);
        } else {
            return;
        }
    }

    public function sendPendingEmail($post)
    {
        $author = get_userdata($post->post_author);
        $recipients = $this->getOption('pending_recipients');
        $subject = __('New Pending PMG Blog Post: ', 'pmg').$post->post_title;
        $message = $this->buildMessage(
            $post,
            get_userdata($post->post_author),
            get_edit_post_link($post->ID, '')
        );

        wp_mail($recipients, $subject, $message);
    }

    public function sendPublishEmail($post)
    {
        $recipients = $this->getOption('published_recipients');
        $subject = __('A new blog post has been published: ', 'pmg').$post->post_title;
        $message = $this->buildMessage(
            $post,
            get_userdata($post->post_author),
            get_permalink($post->ID)
        );

        wp_mail($recipients, $subject, $message);
    }

    public function buildMessage($post, $author, $link)
    {
        $message = __('Status: ', 'pmg').$post->post_status;
        $message .= "\n\n";
        $message .= __('Title: ', 'pmg').$post->post_title;
        $message .= "\n\n";
        $message .= __('Author: ', 'pmg').$author->display_name;
        $message .= "\n\n";
        $message .= __('Link: ', 'pmg').$link;

        return $message;
    }

    public function getOption($fieldName)
    {
        $option = get_option(self::SETTINGS_SECTION, array());
        $value = isset($option[self::PREFIX.$fieldName]) ? $option[self::PREFIX.$fieldName] : '';

        return $value;
    }
}
