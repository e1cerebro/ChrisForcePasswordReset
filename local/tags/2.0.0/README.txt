=== Chris Force Password Reset ===
Contributors: nwachuku, 
Tags: password, reset, security, login, protection
Requires at least: 4.6
Tested up to: 4.7
Stable tag: 4.3
Requires PHP: 5.2.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This plugin is designed to remind WordPress users to reset their password after certain number of days.

== Description ==

This plugin is designed to remind WordPress users to reset their password after certain number of days.
 
== Installation ==

1. Upload `chris-force-password-reset.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place `<?php do_action('plugin_name_hook'); ?>` in your templates
 

== Frequently Asked Questions ==

= Where can I find the settings page after installing the plugin? =

The settings can be found on the Settings menu

= Does the plugin work for custom user capabilities? =

Currently the plugin only supports the default WordPress user capabilities

= How does the plugin work? =

When the plugin is installed, visit the plugin menu under the settings page.
Select the number of days before the password will be reset
Select the user capabilities that are required to update their password.
if you are among the user group, you will be logged out of WordPress dashboard  and redirected to the password reset page
Enter your WordPress account email in the text field and submit.
You will be sent a password reset link to that email
Update your password and try to login again.


== Screenshots ==
1-This is the main settings controls of the plugin
2-The menu link for the plugin can be found under the settings menu
3-Sample image of a saved setup.
4-The plugin name under your plugin menu.