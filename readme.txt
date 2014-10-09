=== MQ ReLinks ===
Contributors: MaiQ
Donate link: http://www.maiq.info/work/wordpress/mq-relinks/
Tags: link, redirect
Requires at least: 3
Tested up to: 4.0
Stable tag: 1.5
Version:1.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Inserts target="_blank" and rewrites all direct links in posts, widgets, comments and author links, to a out.php file.

== Description ==

MQ ReLinks is a wordpress plugin which allows you to easy make all external links in posts, comments and author links non external, by using a redirect.
In stead of a direct link to another site, the plugin will create a link to a out.php file that will redirect to the requested URL. They can be opened in a new window or in the same one.
You can configure the post, comment and author link options in the administration area.

For configuration go to Options>MQ ReLinks

A redirected link will look like this:

http://www.maiq.info/wp-content/plugins/mq-relinks/out.php?url=http://www.wordpress.org/

Or you can edit it to look like this:

http://www.maiq.info/out/http://www.wordpress.org/

To do so you have to edit the .htaccess file and add a line of code:

RewriteRule ^out/(.*)$ wp-content/plugins/mq-relinks/out.php?url=$1 [L]

right after this part of code:

# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]

There are instructions in the administration area

== Changelog ==

=Changes in 1.1=

Updated to work with latest version of wordpress
Added support for anchor links (Ex.: href=#top)

=Changes in 1.2=

Updated to work with latest version of wordpress
Fixed support for anchor links (Ex.: href=#top) will not be redirected, but www.someothersite.com/#something will still work
Added .htaccess support, now your links can look like http://www.maiq.info/out/http://www.wordpress.org/ In stead of http://www.maiq.info/wp-content/plugins/mq-relinks/out.php?url=http://www.wordpress.org/

=Changes in 1.3=

Updated to work with latest version of wordpress
Fixed/added support for javascript links (Ex.: href=javascript:void(0)) will not be redirected.
Fixed/added support for image links; .jpg, .gif and .png links will not be redirected. You can enable/disable this feature in the administration area.

=Changes in 1.4=
Added widget suport
Updated to work with latest version of wordpress

=Changes in 1.5=
Bug fixes
== Installation ==

1. Unzip the downloaded package and upload the MQ ReLinks folder into your Wordpress plugins folder
2. Log into your WordPress admin panel
3. Go to Plugins and "Activate" the plugin
   "MQ ReLinks" will now be displayed in your Options section 
4. Configure it under Options -> MQ ReLinks

== Frequently Asked Questions ==

=1.How do I report a bug?=
Contact me on my blog. Describe the problem as good as you can, your plugin version, Wordpress version and possible conflicting plugins and so on.

=2.How can I support this plugin?=
The best way to contribute is to spread the word, link to this page, blog about MQ ReLinks or give me feedback. 
All kinds of feedback are helpful to me. Suggestions, bug reports and donations are also welcome.


== More ==

For more informatons please visit http://www.maiq.info/work/wordpress/mq-relinks/