=== Careerist ===
Contributors: smartcoding
Tested up to: 6.0.1
Requires at least: 4.7
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Careerist plugin. Syncs careers with 3rd party providers.

== Description ==

Congratulations on installing Careerist plugin developed personally for your
project by Sergey Lukin

This plugin syncs your Wordpress installation with 3rd party careers APIs.

== Frequently Asked Questions ==

= How may I setup daily scheduled background sync task in upress.io? =

In order to set up a scheduled sync task in uPress follow these steps:

  - Log in to your account, navigate to
    `https://my.upress.co.il/account/websites` and select your website

  - Press Advanced settings

  - Press Manage Cron Jobs

  - Add a task with following command: `curl --silent
    "WEBSITE_URL/wp-admin/admin-ajax.php?action=careerist_sync_trigger"` where
    `WEBSITE_URL` is your website URL in format of `https://example.com`

    Of course replace URLs with yours if they are different :)

== Changelog ==

= 1.2 =
* Display sync task run exact steps in Logs view

= 1.1 =
* Add sync task runs logs and display them in back-end UI Logs view

= 1.0 =
* Stable release
* Jobs sync with Adam API
* Back-end UI
* PHP API for search box
