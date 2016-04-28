<?php
/*
Plugin Name: Social Share Buttons 5+ by Nokes
Description: Adds the twitter, linkedin, digg, facebook and gplus button below the content
Version: 1.2.1
Author: Nico Hemkes
Author URI: http://www.nokes.de/
*/

$thisfile	=	basename(__FILE__, ".php");

register_plugin(
	$thisfile,
	'Share 5+',
	'1.2.1',
	'Nico Hemkes',
	'http://hemk.es/',
	'Social Share Buttons 5+ by Nico Hemkes. Implements facebook, twitter, linkedin and google+ share button below the content.',
	'',
	''
);

add_action('theme-header', 'share5plus');
add_action('content-bottom', 'share_5plus_count');

function share5plus() {
	echo '<!-- Plugin by www.nokes.de -->
	<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
	<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	<script type="text/javascript" src="http://platform.linkedin.com/in.js"></script>
	<script type="text/javascript">
	(function() {
	var s = document.createElement(\'SCRIPT\'), s1 = document.getElementsByTagName(\'SCRIPT\')[0];
	s.type = \'text/javascript\';
	s.async = true;
	s.src = \'http://widgets.digg.com/buttons.js\';
	s1.parentNode.insertBefore(s, s1);
	})();
	</script>
	<style type="text/css">#shareline{margin: 0 auto; height: 30px; overflow: hidden; margin-top: 4px;}</style>
	';
}

function share_5plus_count() { 
	$cmsurl = htmlentities('http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
	echo '
	<!--  Social Share Plugin --><div id="shareline">
	<a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a>
	<iframe src="http://www.facebook.com/plugins/like.php?href='.$cmsurl.'&amp;send=false&amp;layout=button_count&amp;width=80&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:21px;" allowTransparency="true"></iframe>
	<script type="in/share" data-counter="right"></script>
	<a class="DiggThisButton DiggCompact"></a>
	<g:plusone size="medium"></g:plusone>
	</div><!-- END - Social Share Plugin -->';
}

?>
