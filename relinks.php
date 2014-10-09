<?php
/*
Plugin Name: MQ ReLinks
Plugin URI: http://www.maiq.info/
Description: Inserts target="_blank" and rewrites all direct links in posts, widgets, comments and author links, to a out.php file.
Version: 1.5
Author: maiq
Author URI: http://www.maiq.info/
	Copyright (c) 2008 - 2014 maiq (http://www.maiq.info)
	MQ ReLinks is released under the GNU General Public
	License (GPLv2) http://www.gnu.org/licenses/gpl-2.0.html
	This is a WordPress plugin (http://wordpress.org).
*/
	// variables for the fields and option names 
	$opt_name =array( 'replace_in_post', 'blank_in_post', 'replace_in_comment', 'blank_in_comment', 'replace_in_author_comment_link', 'blank_in_author_comment_link','mq_use_pretty_url','mq_replace_image_links','replace_in_widget_link','blank_in_widget_link','qr_path');
	global $opt_name;
	
function mq_relinks_install(){
	$opt_name =array( 'replace_in_post', 'blank_in_post', 'replace_in_comment', 'blank_in_comment', 'replace_in_author_comment_link', 'blank_in_author_comment_link','mq_use_pretty_url','mq_replace_image_links','replace_in_widget_link','blank_in_widget_link','qr_path');
	//add the options and values
	foreach ($opt_name as $cz){ 
	((get_option($cz) != 'yes') || (get_option($cz) != 'no')) ? update_option($cz, 'no') : add_option($cz, 'no', '', 'no'); 
	}
	(get_option('qr_path') != 'wp-content/plugins/mq-relinks/') ? update_option('qr_path', 'wp-content/plugins/mq-relinks/') : add_option('qr_path','wp-content/plugins/mq-relinks/', '', 'no'); 
}

function mq_relinks_uninstall(){
	$opt_name =array( 'replace_in_post', 'blank_in_post', 'replace_in_comment', 'blank_in_comment', 'replace_in_author_comment_link', 'blank_in_author_comment_link','mq_use_pretty_url','mq_replace_image_links','replace_in_widget_link','blank_in_widget_link','qr_path');
	// delete options
	foreach ($opt_name as $cz){ delete_option($cz);	}
	delete_option('qr_path');
}	

	//options page
function mq_relinks_options_page() {
#var_dump($_POST);
	global $opt_name;
		
	//set hidden field name
    $hidden_field_name = 'mq_relinks_submit_hidden';
	
	//check if options exist
	foreach ($opt_name as $content){ 	if( $mq_relinks_options_value[$content] !='no' || $mq_relinks_options_value[$content] !='yes' ) add_option($content, 'no');	}
	(get_option('qr_path') != 'wp-content/plugins/mq-relinks/') ? update_option('qr_path', 'wp-content/plugins/mq-relinks/') : add_option('qr_path','wp-content/plugins/mq-relinks/', '', 'no'); 
	
	//get the option values
	foreach ($opt_name as $mq_relinks_options){ $mq_relinks_options_value[$mq_relinks_options] = get_option( $mq_relinks_options ); }
	$qr_path_value = get_option('qr_path');
	
	//if the form is posted
    if( $_POST[ $hidden_field_name ] == 'Y' ) {
	
	//get the posted values
	foreach ($opt_name as $mq_relinks_options_posted){     $mq_relinks_options_posted_value[$mq_relinks_options_posted] = $_POST[ $mq_relinks_options_posted ];	}
	
	//update the option values
	foreach ($opt_name as $posted_opt_name ){	update_option( $posted_opt_name, $mq_relinks_options_posted_value[$posted_opt_name] );	}
	
	//get the saved option values
	foreach ($opt_name as $mq_relinks_options){    $mq_relinks_options_value[$mq_relinks_options] = get_option( $mq_relinks_options );	}
	$qr_path_value = get_option('qr_path');
	//show a message
?>
<div class="updated"><p><strong><?php _e('Options saved.', 'mq_relinks' ); ?></strong></p></div>
<?php
    }
 	echo '<div class="wrap">
			<h2>'.__('MQ ReLinks Options','mq_relinks').'</h2>
			<div class="postbox-container" style="width:70%">
				<form method="post" action="options-general.php?page=mq_relinks">
				<div class="metabox-holder">
				<div class="meta-box-sortables">
					<div id="edit-pages" class="postbox">
					<div class="handlediv" title="'.__('Click to toggle','mq_relinks').'"><br /></div>
					<h3 class="hndle"><span>'.__('Plugin Settings','mq_relinks').'</span></h3>
					<div class="inside">				
<table>';
	foreach ($opt_name as $mq_relinks_options){
		if($mq_relinks_options!='qr_path'){
			echo'<tr><td>';
			$words = ucwords(str_replace("_"," ", $mq_relinks_options));
			echo $words.':';
			echo '</td><td>
			<select name="'.$mq_relinks_options.'">
			<option value="yes" ';
			if ($mq_relinks_options_value[$mq_relinks_options] =='yes'){echo 'selected';}
			echo'>'.__('Yes').'</option>
			<option value="no"';
			if ($mq_relinks_options_value[$mq_relinks_options] =='no'){echo 'selected';}
			echo'>'.__('No').'</option>
			</select>
			</td></tr>';
		}
	}
	
echo'
</table>
<br><br>
Add the following line to your .htaccess file if you want the pretty url feature enabled:<br>
<input disabled type="text" style="width:500px;" value="RewriteRule ^out/(.*)$ wp-content/plugins/mq-relinks/out.php?url=$1 [L]">
<br>
So your .htaccess will look like this:<br>
<textarea style="width:520px; height:235px;" disabled>
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteRule ^out/(.*)$ wp-content/plugins/mq-relinks/out.php?url=$1 [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
</textarea>

					</div><!-- .inside -->
					</div><!-- #edit-pages -->
					<input type="hidden" name="'.$hidden_field_name.'" value="Y">
					<input type="submit" name="Submit" class="button-primary" value="'.__('Save Settings','mq_relinks').'" />
					</form>
				</div><!-- .meta-box-sortables -->
				</div><!-- .metabox-holder -->
				
			</div><!-- .postbox-container -->
			
			<div class="postbox-container" style="width:20%">
			
				<div class="metabox-holder">
				<div class="meta-box-sortables">
				
					<div id="edit-pages" class="postbox">
					<div class="handlediv" title="'.__('Click to toggle','mq_relinks').'"><br /></div>
					<h3 class="hndle"><span>'.__('Plugin Information','mq_relinks').'</span></h3>
					<div class="inside">
						<p>'.__(' If you\'ve enjoyed the plugin please give the plugin 5 stars on WordPress.org.','mq_relinks').'</p>
						<p>'.__('Want to help?<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=andreiburca@gmail.com&currency_code=EUR&amount=&return=&item_name=MQ Relinks plugin" target="_new"><img src="../wp-content/plugins/mq-relinks/donate.gif"></a>
','mq_relinks').'</p>
						<p><a href="http://wordpress.org/plugins/mq-relinks/">WordPress.org</a> | <a href="http://www.maiq.info/work/wordpress/mq-relinks/">'.__('Plugin Author','mq_relinks').'</a></p>
					</div><!-- .inside -->
					</div><!-- #edit-pages -->
				
				</div><!-- .meta-box-sortables -->
				</div><!-- .metabox-holder -->
				
			</div><!-- .postbox-container -->	
	</div><!-- .wrap -->';
}
	//function to add the page to the admin settings menu
function mq_ReLinks_add_pages() { 
	$mq_relinks_settings=add_options_page('MQ ReLinks', 'MQ ReLinks', 8, 'mq_relinks', 'mq_relinks_options_page');  
	add_action('load-'.$mq_relinks_settings, 'mq_relinks_help_page_scripts');
	}
 
function mq_relinks_help_page_scripts() {
	wp_enqueue_style('dashboard');
	wp_enqueue_script('postbox');
	wp_enqueue_script('dashboard');
}
 function mq_ReLinks_content($str, $arg = 1) {
    // manipulate hyperlinks in $str...
    if (!isset($str)) return $str;
    if (!$arg) return $str;
    return preg_replace_callback('#<a\s([^>]*\s*href\s*=[^>]*)>#i', 'mq_ReLinks_replaceit_post', $str);
}

 function mq_ReLinks_comment($str, $arg = 1) {
    // manipulate hyperlinks in $str...
    if (!isset($str)) return $str;
    if (!$arg) return $str;
    return preg_replace_callback('#<a\s([^>]*\s*href\s*=[^>]*)>#i', 'mq_ReLinks_replaceit_comment', $str);
}
 function mq_ReLinks_widget($str, $arg = 1) {
    // manipulate hyperlinks in $str...
    if (!isset($str)) return $str;
    if (!$arg) return $str;
    return preg_replace_callback('#<a\s([^>]*\s*href\s*=[^>]*)>#i', 'mq_ReLinks_replaceit_comment', $str);
}
function mq_ReLinks_replaceit_post($matches) {
	global $opt_name;
    $str = $matches[1];
    preg_match_all('/[^=[:space:]]*\s*=\s*"[^"]*"|[^=[:space:]]*\s*=\s*\'[^\']*\'|[^=[:space:]]*\s*=[^[:space:]]*/', $str, $attr);
    $href_arr = preg_grep('/^href\s*=/i', $attr[0]);
    if (count($href_arr) > 0) $href = array_pop($href_arr);
	if ($href) {
	foreach ($opt_name as $mq_relinks_options){ $mq_relinks_options_value[$mq_relinks_options] = get_option( $mq_relinks_options );	}
	$extensions=array("jpg","gif","png");
	$relink_path_value = get_option('qr_path');
	$blogurl = get_bloginfo('url');
	$blog_url = parse_url(get_bloginfo('url'));
	$blog_host = $blog_url['host'];
	$local = strpos($href, $blog_host);
	$javalink = strpos($href, "javascript:");
	$y = preg_replace("#\"#","",$href);
	$ext = substr(strrchr(strtolower($y),'.'),1);
	$isimage = (in_array($ext, $extensions)===true) ? "yes" : "no";
	if ($mq_relinks_options_value['blank_in_post'] =='yes'){ if (($local === false) && ($javalink === false) &&  ($href{6}!="#") && ($href{7}!="#") ) $blank = 'target="_blank"';}
	if ($mq_relinks_options_value['replace_in_post'] =='yes'){
		if( ($isimage == 'yes' ) && ($mq_relinks_options_value['mq_replace_image_links'] == 'no')){
		return;
		}else{
			if (($local === false) && ($javalink === false) && ($href{6}!="#") && ($href{7}!="#") ) {
				if ($mq_relinks_options_value['mq_use_pretty_url'] =='no'){
					$href = preg_replace('/^(href\s*=\s*[\'"]?)/i', '\1'.$blogurl.'/'.$relink_path_value.'out.php?url=', $href);
				}else{
					$href = preg_replace('/^(href\s*=\s*[\'"]?)/i', '\1'.$blogurl.'/out/', $href);
				}
			}
		}
	}
	$attr = preg_grep('/^href\s*=/i', $attr[0], PREG_GREP_INVERT);
    return '<a '.$blank .' '. join(' ', $attr) . ' ' . $href . '>';
	// return $href;
	}
}

function mq_ReLinks_replaceit_comment($matches) {
	global $opt_name;
	foreach ($opt_name as $mq_relinks_options){
		$mq_relinks_options_value[$mq_relinks_options] = get_option( $mq_relinks_options );
	}
	$relink_path_value = get_option('qr_path');
	$burl = get_bloginfo('url').'/';
    $str = $matches[1];
    preg_match_all('/[^=[:space:]]*\s*=\s*"[^"]*"|[^=[:space:]]*\s*=\s*\'[^\']*\'|[^=[:space:]]*\s*=[^[:space:]]*/', $str, $attr);
    $href_arr = preg_grep('/^href\s*=/i', $attr[0]);
    if (count($href_arr) > 0)
        $href = array_pop($href_arr);
	if ($href) {
	$local = strpos($href, $burl);
	if ($mq_relinks_options_value['blank_in_comment'] =='yes'){if (($local === false) && ($href{6}!="#") && ($href{7}!="#") ) $blank = 'target="_blank"';} 
	if ($mq_relinks_options_value['replace_in_comment'] =='yes'){
	if (($local === false) &&  ($href{6}!="#") && ($href{7}!="#") ) {
			if ($mq_relinks_options_value['mq_use_pretty_url'] =='no'){
	        $href = preg_replace('/^(href\s*=\s*[\'"]?)/i', '\1'.$burl.$relink_path_value.'out.php?url=', $href);
			}else{
			$href = preg_replace('/^(href\s*=\s*[\'"]?)/i', '\1'.$burl.'out/', $href);
			}
		}
    $attr = preg_grep('/^href\s*=/i', $attr[0], PREG_GREP_INVERT);
	}
    return '<a '.$blank . join(' ', $attr) . ' ' . $href . '>';
	}
}

	//filter comment author link
function mq_auth_ReLinks($link) {
	global $opt_name;
	foreach ($opt_name as $mq_relinks_options){
		$mq_relinks_options_value[$mq_relinks_options] = get_option( $mq_relinks_options );
	}
	$relink_path_value = get_option('qr_path');
	$burl = get_bloginfo('url').'/';
	$local = strpos($link, $burl);
	if ($local === false) 
	if ($mq_relinks_options_value['replace_in_author_comment_link'] =='yes'){
	if ($mq_relinks_options_value['blank_in_author_comment_link'] =='yes'){if ($local === false) $blank = 'target="_blank"';}
    if ($mq_relinks_options_value['mq_use_pretty_url'] =='no'){
	$link = preg_replace("#(.*href\s*=\s*)[\"\']*(.*)[\"\'] (.*)#i", "<a ".$blank." href='".$burl.$relink_path_value."out.php?url=$2' $3", $link);
	}else{
	$link = preg_replace("#(.*href\s*=\s*)[\"\']*(.*)[\"\'] (.*)#i", "<a ".$blank." href='".$burl."out/$2' $3", $link);
	}

	}
	return $link;
} 
function mq_ReLinks_replaceit_widget($link) {
	global $opt_name;
    $str = $matches[1];
    preg_match_all('/[^=[:space:]]*\s*=\s*"[^"]*"|[^=[:space:]]*\s*=\s*\'[^\']*\'|[^=[:space:]]*\s*=[^[:space:]]*/', $str, $attr);
    $href_arr = preg_grep('/^href\s*=/i', $attr[0]);
    if (count($href_arr) > 0) $href = array_pop($href_arr);
	if ($href) {
	foreach ($opt_name as $mq_relinks_options){ $mq_relinks_options_value[$mq_relinks_options] = get_option( $mq_relinks_options );	}
	$extensions=array("jpg","gif","png");
	$relink_path_value = get_option('qr_path');
	$blogurl = get_bloginfo('url');
	$blog_url = parse_url(get_bloginfo('url'));
	$blog_host = $blog_url['host'];
	$local = strpos($href, $blog_host);
	$javalink = strpos($href, "javascript:");
	$y = preg_replace("#\"#","",$href);
	$ext = substr(strrchr(strtolower($y),'.'),1);
	$isimage = (in_array($ext, $extensions)===true) ? "yes" : "no";
	if ($mq_relinks_options_value['blank_in_widget'] =='yes'){ if (($local === false) && ($javalink === false) &&  ($href{6}!="#") && ($href{7}!="#") ) $blank = 'target="_blank"';}
	if ($mq_relinks_options_value['replace_in_widget'] =='yes'){
		if( ($isimage == 'yes' ) && ($mq_relinks_options_value['mq_replace_image_links'] == 'no')){
		return;
		}else{
			if (($local === false) && ($javalink === false) && ($href{6}!="#") && ($href{7}!="#") ) {
				if ($mq_relinks_options_value['mq_use_pretty_url'] =='no'){
					$href = preg_replace('/^(href\s*=\s*[\'"]?)/i', '\1'.$blogurl.'/'.$relink_path_value.'out.php?url=', $href);
				}else{
					$href = preg_replace('/^(href\s*=\s*[\'"]?)/i', '\1'.$blogurl.'/out/', $href);
				}
			}
		}
	}
	$attr = preg_grep('/^href\s*=/i', $attr[0], PREG_GREP_INVERT);
    return '<a '.$blank .' '. join(' ', $attr) . ' ' . $href . '>';
	// return $href;
	}
} 

//install and uninstall functios
register_activation_hook( __FILE__, 'mq_relinks_install' );
register_deactivation_hook( __FILE__,'mq_relinks_uninstall');
register_uninstall_hook( __FILE__,'mq_relinks_uninstall');
//execute the function that adds the options page
add_action('admin_menu', 'mq_ReLinks_add_pages');
// add_action('activated_plugin','my_save_error');
// function my_save_error() {  file_put_contents(dirname(__file__).'/error_activation.txt', ob_get_contents()); }
//execute the filters
add_filter('the_content', 'mq_ReLinks_content');
add_filter('comment_text', 'mq_ReLinks_comment');
add_filter('get_comment_author_link', 'mq_auth_ReLinks');
add_filter('widget_text', 'mq_ReLinks_widget');
?>