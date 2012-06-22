<?php
/*
Plugin Name: Social Media with Defered Javascript
Plugin URI: http://wordpress.org/extend/plugins/social-media-with-defered-javascript/
Description: Adds social media below your wordpress posts with defered Javascript for improved performance. Includes Twitter, Facebook like, google plus and Digg. This plugin adds the javascript to the bottom of the page and combined in to a single script. Styling included within the code so no extra CSS. The plugin is designed to be light and minimal and yet provide you with the same results as other social media plugins.
Version: 1.0.0.3
Author: Matthew Horne
Donate Link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8K3Z6N6KXPJYU
Author URI: http://diywpblog.com
License: GPLv2 or later
*/

/*  Copyright 2012  Matthew Horne  (email : mattjhorne@hotmail.co.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Set-up Action and Filter Hooks

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'smwdjs_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'smwdjs_remove' );

function smwdjs_install() {
/* Creates new database field */
add_option("smwdjs_twitterid", 'DIY_WP_Blog', '', 'yes');
}

function smwdjs_remove() {
/* Deletes the database field */
delete_option('smwdjs_twitterid');
}

if ( is_admin() ){

/* Call the html code */
add_action('admin_menu', 'smwdjs_admin_menu');

function smwdjs_admin_menu() {
add_options_page('Social Media With Defered JS', 'Social Media With Defered JS', 'administrator',
'social-media-with-defered-js', 'smwdjs_html_page');
}
}

/* Adds content to admin settings */
function smwdjs_html_page() {
?>
<div id="smwdjs_admin_page" style="float: left; padding-left: 20px;">
<h1>Social Media With Defered JS Options</h1>
<h3>By Matthew Horne at <a href="http://diywpblog.com" target=_"blank">DIY WP Blog</a></h3>
</br>
<div id="smwdjs_admin_info" style="width: 600px; float: left;"><strong><p style=" font-size:18px; line-height: 1.4; margin: 1em 0; padding-bottom: 100px;">Thank you for using DIY WP Blogs Social Media with Defered Javascript Plugin for Wordpress.
This Plugin is design to add social media buttons below your wordpress posts and defer the javascript for improved performance. This plugin contains no additional stylesheet and a single script that loads the remaining javascript, this allows you do add social media without compromising performance.</p>
<p>Nice and simple, only one option for the moment, just add you Twitter ID without the '@' and anyone who tweets your post will tweet via your Twitter ID.</p></strong>
<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>
<table width="510">
<tr valign="top">
<th width="92" style="font-size: 18px;" scope="row">Twitter ID</th>
<td width="406">
<input type="text" name="smwdjs_twitterid" id="smwdjs_twitterid" size="45" value="<?php echo get_option('smwdjs_twitterid'); ?>" /> 
</td>
</tr>
</table>
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="smwdjs_twitterid" />
</br>
</br>
<input type="submit" style="border-color: #306eff; width:200px; height:60px; margin-left: 20px; background-color: #3090C7; font-size: 23px;" value="<?php _e('Save Changes') ?>" />
</form>
</div>
<div id="smwdjs_info_box" style="width: 260px; float: right; padding-left: 40px;">
<strong><p style="font-size: 16px; line-height: 1.4; margin: 1em 0;">If you like this plugin. Please condsider a donation to help further development and Projects.</p></strong>
<form action="https://www.paypal.com/cgi-bin/webscr" target="_blank" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="LMFT2QNN4CXEC">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form>
<h2>Future Projects In Progress</h2> 
<h3>Widgetized Feature Box</h3>
</br>
<h2>Follow us Online</h2>
<a target="_blank" href="http://feeds.feedburner.com/~r/DiyWPBlog/~6/1"><img src="http://feeds.feedburner.com/DiyWPBlog.1.gif" alt="DIY WP Blog" style="border:0"></a>
<p>Please rate this plugin and inform us of any issues</p>
<p>Your feedback is invaluable for us to progress, if you would like more functionality Contact me <a href="http://diywpblog.com/contact/" target="_blank">here</a></p> 
</div>
<?php
}

/* Adds the social media icons to the posts */
function social_media($content) {
	if (is_single()) {
		$content .= '	
    <div class="social-post" style="float: left; padding: 10px 0px; width:100%;">
    <div class="counter-twitter" style="float: left; padding-left: 10px;"><a href="http://twitter.com/share" class="twitter-share-button" data-via="' .get_option('smwdjs_twitterid') . '" data-text="' . get_the_title($post->ID) . '" data-url="' . get_permalink($post->ID) . '" data-count="vertical">Tweet</a></div>
    <div class="counter-fb-like" style="float: left; padding-left: 10px;">
    <div id="fb-root"></div><fb:like layout="box_count" href="' . get_permalink($post->ID) . '-" send="false" width="50" show_faces="false"></fb:like>
    </div>
    <div class="counter-google-one" style="float: left;"><g:plusone size="tall" href="' . get_permalink($post->ID) . '"></g:plusone></div>
<div class="digbutton" style="float: left; padding-left: 10px;"><div class="DiggThisButton DiggMedium"></div></div>
</div>
';
	}
	return $content;
}
add_filter('the_content', 'social_media');

/* Defers the javascript */
function java_to_bottom() {
    if (is_single(array())) { // Change the name to match the name(s) of the pages using the form ?>
<script>(function(d, s) {
  var js, fjs = d.getElementsByTagName(s)[0], load = function(url, id) {
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.src = url; js.id = id;
    fjs.parentNode.insertBefore(js, fjs);
  };
  load('//connect.facebook.net/en_US/all.js#xfbml=1', 'fbjssdk');
  load('https://apis.google.com/js/plusone.js', 'gplus1js');
  load('//platform.twitter.com/widgets.js', 'tweetjs');
  load('//widgets.digg.com/buttons.js', 'digjs');
}(document, 'script'));</script>
 
    <?php } }
add_action('wp_footer', 'java_to_bottom');

?>