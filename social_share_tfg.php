<?php
/*
Plugin Name: Social Share Buttons (3+)
Description: Implements facebook, twitter and google+ share button below the content. For simple sharing
Version: 1.1.2
Author: Nico Hemkes
Author URI: http://hemk.es/
*/

$thisfile=basename(__FILE__, ".php");

register_plugin(
	$thisfile,
	'Social Share Buttons (3+)',
	'1.1.2',
	'Nico Hemkes',
	'http://hemk.es/',
	'Implements facebook, twitter and google+ share button below the content. For simple sharing.',
	'',
	''
);

add_action('theme-header', 'share3plus');
add_action('content-bottom', 'share3count');

function share3plus() {
echo '<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
<style type="text/css">#shareline{margin: 0 auto; height: 30px; overflow: hidden; margin-top: 4px;}</style>
	';
}

function share3count() {
	$cmsurl = htmlentities('http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
	echo '<!-- Social Share Plugin by www.hemk.es --><div id="shareline"><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a><iframe src="http://www.facebook.com/plugins/like.php?href='.$cmsurl.'&amp;send=false&amp;layout=button_count&amp;width=105&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:110px; height:21px;" allowTransparency="true"></iframe><g:plusone size="medium"></g:plusone></div><!-- END -->';
}

?>