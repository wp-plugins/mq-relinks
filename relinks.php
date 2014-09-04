<?php
/*
Plugin Name: MQ ReLinks
Plugin URI: http://www.maiq.info/
Description: Inserts target="_blank" and rewrites all direct links in posts, comments and author links, to a out.php file.
Version: 1.3
Author: maiq
Author URI: http://www.maiq.info/
	Copyright (c) 2008 - 2012 maiq (http://www.maiq.info)
	MQ ReLinks is released under the GNU General Public
	License (GPL) http://www.gnu.org/licenses/gpl.txt
	This is a WordPress plugin (http://wordpress.org).
*/
	// variables for the fields and option names 
	$opt_name =array( 'replace_in_post', 'blank_in_post', 'replace_in_comment', 'blank_in_comment', 'replace_in_author_comment_link', 'blank_in_author_comment_link','mq_use_pretty_url','mq_replace_image_links');
	global $opt_name;
	
function mq_relinks_install(){
	global $opt_name;
	//add the options and values
	foreach ($opt_name as $contentz){
		if ( (get_option( $contentz ) == '') || (get_option( $contentz ) != 'yes') ) {
			update_option( $contentz, 'yes' );
		} else {
			$deprecated = ' ';
			$autoload = 'no';
			add_option( $contentz, 'yes', $deprecated, $autoload );
		}
	}
	if ( get_option( 'relink_path' ) != 'wp-content/plugins/mq-relinks/' ) {
		update_option( 'relink_path', 'wp-content/plugins/mq-relinks/' );
	} else {
		$deprecated = ' ';
		$autoload = 'no';
		add_option('relink_path','wp-content/plugins/mq-relinks/', $deprecated, $autoload);
	}
}

function mq_relinks_uninstall(){
	global $opt_name;
	// delete options
	foreach ($opt_name as $contentz){
	delete_option($contentz);
	}
	delete_option('relink_path');
}	

	//options page
function mq_relinks_options_page() {
	global $opt_name;
	
if( function_exists( 'load_plugin_textdomain' ) ) {
			load_plugin_textdomain( 'mq_relinks', 'wp-content/plugins/mq-relinks' );
}
		
	//set hidden field name
    $hidden_field_name = 'mq_relinks_submit_hidden';
	
	//check if options exist
	foreach ($opt_name as $content){
	if( $mq_relinks_options_value[$content] =='')
	add_option($content, 'yes');
	}
	
	if( $mq_relinks_options_value['relink_path'] !='wp-content/plugins/mq-relinks/') 	add_option('relink_path', 'wp-content/plugins/mq-relinks/');
	
	
	//get the option values
	foreach ($opt_name as $mq_relinks_options){
    $mq_relinks_options_value[$mq_relinks_options] = get_option( $mq_relinks_options );
	}
	$relink_path_value = get_option('relink_path');
	
	//if the form is posted
    if( $_POST[ $hidden_field_name ] == 'Y' ) {
	
	//get the posted values
	foreach ($opt_name as $mq_relinks_options_posted){
    $mq_relinks_options_posted_value[$mq_relinks_options_posted] = $_POST[ $mq_relinks_options_posted ];
	}
	
	//update the option values
	foreach ($opt_name as $posted_opt_name ){
	update_option( $posted_opt_name, $mq_relinks_options_posted_value[$posted_opt_name] );
	}
	
	//get the saved option values
	foreach ($opt_name as $mq_relinks_options){
    $mq_relinks_options_value[$mq_relinks_options] = get_option( $mq_relinks_options );
	}
	$relink_path_value = get_option('relink_path');
	//show a message
?>
<div class="updated"><p><strong><?php _e('Options saved.', 'mt_trans_domain' ); ?></strong></p></div>
<?php
    }
    echo '<div class="wrap">';
    echo "<h2>" . __( 'MQ ReLinks Options', 'mt_trans_domain' ) . "</h2>";
?>
<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p>
<table>
<?php
	foreach ($opt_name as $mq_relinks_options){
	echo'<tr><td>';
	$words = ucwords(str_replace("_"," ", $mq_relinks_options));
	echo $words.':';
	echo '</td><td>
	<select name="'.$mq_relinks_options.'">
	<option></option>
	<option value="yes" ';
	if ($mq_relinks_options_value[$mq_relinks_options] =='yes'){echo 'selected';}
	echo'>'.__('Yes').'</option>
	<option value="no"';
	if ($mq_relinks_options_value[$mq_relinks_options] =='no'){echo 'selected';}
	echo'>'.__('No').'</option>
	</select>
	</td></tr>';
	}
?>
</table>
</p>

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'mt_trans_domain' ) ?>" />
</p>

</form>
<?php
echo'<br/>'.mq_add_info().'</div>';
 }

	//function to add the page to the admin settings menu
function mq_ReLinks_add_pages() {
add_options_page('MQ ReLinks', 'MQ ReLinks', 8, 'mqrelinks', 'mq_relinks_options_page');
 }

function mq_add_info(){

return '
<div id="brag">
'.__('Add the following line to your .htaccess file if you want the pretty url feature enabled:').'<br>
<input type="text" style="width:500px;" value="RewriteRule ^out/(.*)$ wp-content/plugins/mq-relinks/out.php?url=$1 [L]">
<br>
'.__('So your .htaccess will look like this:').'<br>
<textarea style="width:500px; height:200px;">
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
<br><span style="position:absolute;top:150px;right:100px;">
'.__('Thanks for using my plugin.').'
<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=andreiburca@gmail.com&currency_code=EUR&amount=&return=&item_name=MQ Relinks plugin" target="_new"><img src="../wp-content/plugins/mq-relinks/donate.gif"></a>
<br>
'.__('For updates visit the plugin page').' <a href="http://www.maiq.info/work/wordpress/mq-relinks/" target="_new">'.__('here').'</a>
</span>
</div>';
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

function mq_ReLinks_replaceit_post($matches) {
	global $opt_name;
    $str = $matches[1];
    preg_match_all('/[^=[:space:]]*\s*=\s*"[^"]*"|[^=[:space:]]*\s*=\s*\'[^\']*\'|[^=[:space:]]*\s*=[^[:space:]]*/', $str, $attr);
    $href_arr = preg_grep('/^href\s*=/i', $attr[0]);
    if (count($href_arr) > 0) $href = array_pop($href_arr);
	if ($href) {
	foreach ($opt_name as $mq_relinks_options){ $mq_relinks_options_value[$mq_relinks_options] = get_option( $mq_relinks_options );	}
	$extensions=array("jpg","gif","png");
	$relink_path_value = get_option('relink_path');
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
	$relink_path_value = get_option('relink_path');
	$burl = get_bloginfo('home').'/';
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
	$relink_path_value = get_option('relink_path');
	$burl = get_bloginfo('home').'/';
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
//install and uninstall functios
add_action('activate_mqrelinks/relinks.php', 'mq_relinks_install');
add_action('deactivate_mqrelinks/relinks.php', 'mq_relinks_uninstall');  
//execute the function that adds the options page
add_action('admin_menu', 'mq_ReLinks_add_pages');
//execute the filters
add_filter('the_content', 'mq_ReLinks_content');
add_filter('comment_text', 'mq_ReLinks_comment');
add_filter('get_comment_author_link', 'mq_auth_ReLinks');
?>