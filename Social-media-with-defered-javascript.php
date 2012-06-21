<?php
/*
Plugin Name: Social media with defered Javascript
Plugin URI: http://diywpblog.com
Description: Adds social media below your wordpress posts with defered Javascript for improved performance. Includes Twitter, Facebook like, google plus and Digg. This plugin adds the javascript to the bottom of the page and combined in to a single script. Styling included within the code so no extra CSS. The plugin is designed to be light and minimal and yet provide you with the same results as other social media plugins.
Version: 1.0
Author: Matthew Horne
Donate Link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8K3Z6N6KXPJYU
Author URI: http://diywpblog.com/about/
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

define('SOCIAL_MEDIA_WITH_DEFERED_JAVASCRIPT', '1.0');
define('SOCIAL_MEDIA_WITH_DEFERED_JAVASCRIPT_URL', plugin_dir_url( __FILE__ ));

function social_media($content) {
	if (is_single()) {
		$content .= '
    <div class="social-post" style="float: left; padding: 10px 0px; width:100%;">
    <div class="counter-twitter" style="float: left; padding-left: 10px;"><a data-related="#" href="http://twitter.com/share" class="twitter-share-button" data-text="' . get_the_title($post->ID) . ' —" data-url="' . get_permalink($post->ID) . '" data-count="vertical">Tweet</a></div>
    <div class="counter-fb-like" style="float: left; padding-left: 10px;">
    <div id="fb-root"></div><fb:like layout="box_count" href="' . get_permalink($post->ID) . '" send="false" width="50" show_faces="false"></fb:like>
    </div>
    <div class="counter-google-one" style="float: left;"><g:plusone size="tall" href="' . get_permalink($post->ID) . '"></g:plusone></div>
<div class="digbutton" style="float: left; padding-left: 10px;"><div class="DiggThisButton DiggMedium"></div></div>
</div>
<?php }
}
';
	}
	return $content;
}
add_filter('the_content', 'social_media');


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