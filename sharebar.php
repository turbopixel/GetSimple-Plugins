<?php
/*
Plugin Name: Sharebar
Description: This extension include ten social media icons below the content for more sharing. Only HTML Buttons - compliance with data protection.
Version: 1.1
Author: Nico Hemkes
Author URI: http://www.nokes.de/
*/

// -- init
global $SITEURL;
$thisfile = basename(__FILE__, '.php');
$config_file = GSDATAOTHERPATH . 'nokes_sharebar.xml';

// -- add plugin
register_plugin(
	$thisfile, 									
	'Sharebar',									
	'1.2.5', 										
	'Nico Hemkes', 								
	'http://www.nokes.de/', 					
	'Add html share icons above the content area. Only HTML Buttons - compliance with data protection', 
	'settings',									
	'sharebar_configuration'							
);

// gs action
add_action( 'settings-sidebar','createSideMenu',array( $thisfile, 'Sharebar' ) );
add_action( 'content-bottom', 'sharebar_content', array() );
add_action( 'theme-header', 'sharebar_header', array() );

// -- sharebar data file
if( file_exists( $config_file ) ) {
	$ShareButtons = simplexml_load_file( $config_file );
} else {
	$ShareButtons = new simpleXMLElement( '<channel></channel>' );
	$ShareButtons->addChild( 'active', '0' );
	$ShareButtons->addChild( 'facebook', '0' );
	$ShareButtons->addChild( 'twitter', '0' );
	$ShareButtons->addChild( 'gplus', '0' );
	$ShareButtons->addChild( 'linkedin', '0' );
	$ShareButtons->addChild( 'digg', '0' );
	$ShareButtons->addChild( 'delicious', '0' );
	$ShareButtons->addChild( 'reddit', '0' );
	$ShareButtons->addChild( 'author', '1' );
	$ShareButtons->addChild( 'extent', '3' );
	$ShareButtons->asXML( $config_file );
}

// -- size
$sharebarButtons = array(
		array('id' => 1, 'size' => 14, 'text' => '14x14px'),
		array('id' => 2, 'size' => 16, 'text' => '16x16px'),
		array('id' => 3, 'size' => 20, 'text' => '20x20px'),
		array('id' => 4, 'size' => 22, 'text' => '22x22px'),
		array('id' => 5, 'size' => 24, 'text' => '24x24px'),
		array('id' => 6, 'size' => 28, 'text' => '28x28px'),
	);


/**
 * admin: configuration page
 * @return misc - display configuration page; save data
 */
function sharebar_configuration() {
	global $ShareButtons, $config_file, $sharebarButtons;
	
	if( $_POST['send_options'] == 1 ) {
		$button_active		=	(int)$_POST['active'];
		$button_facebook	=	(int)$_POST['facebook'];
		$button_twitter		=	(int)$_POST['twitter'];
		$button_gplus		=	(int)$_POST['gplus'];
		$button_linkedin	=	(int)$_POST['linkedin'];
		$button_digg		=	(int)$_POST['digg'];
		$button_delicious	=	(int)$_POST['delicious'];
		$button_reddit		=	(int)$_POST['reddit'];
		$button_author		=	(int)$_POST['author'];
		$button_extent		=	(int)$_POST['extent'];
		
		$ShareButtons->active = $button_active;
		$ShareButtons->facebook = $button_facebook;
		$ShareButtons->twitter = $button_twitter;
		$ShareButtons->gplus = $button_gplus;
		$ShareButtons->linkedin = $button_linkedin;
		$ShareButtons->digg = $button_digg;
		$ShareButtons->delicious = $button_delicious;
		$ShareButtons->reddit = $button_reddit;
		$ShareButtons->author = $button_author;
		$ShareButtons->extent = $button_extent;
		$ShareButtons->asXML( $config_file );
		
		$note = '<p class="updated">Updates successful.</p>';
	
	}

	?>

		<h3>sharebar configuration</h3>
		<?php echo( $note ); ?>
		<p>
			<form method="post" action="<?php echo $_SERVER ['REQUEST_URI']; ?>">
			<div id="metadata_window">
				<input type="checkbox" id="post-menu-enable"  name="active" value="1" <?php if($ShareButtons->active == 1){echo "checked";} ?> /> <b>display icons</b>
				<br/>
				<br/>				
				<label for="code">button size</label>
				<select class="text " style="width: 200px;" name="extent">
					<?php 
					foreach( $sharebarButtons AS $btn){

						if( $ShareButtons->extent == $btn['id'] )
							echo '<option selected="selected" value="' . $btn['id'] . '" >' . $btn['text'] . '</option>';
						else
						echo '<option value="' . $btn['id'] . '" >' . $btn['text'] . '</option>';

					}
					?>
				</select>
				<br/>
				<br/>
				<h3>networks</h3>				
				<table cellpadding="0" cellspacing="0" width="100%" style="width:100%">
				
					<tr>
						<td><input type="checkbox" id="post-menu-enable"  name="facebook" <?php if($ShareButtons->facebook == 1){echo "checked";} ?> value="1"  /> <b>Facebook</b></td>
						<td><input type="checkbox" id="post-menu-enable"  name="twitter" <?php if($ShareButtons->twitter == 1){echo "checked";} ?> value="1"  /> <b>Twitter</b></td>						
						<td><input type="checkbox" id="post-menu-enable"  name="gplus" <?php if($ShareButtons->gplus == 1){echo "checked";} ?> value="1"  /> <b>Google+</b> </td>
					</tr>
					<tr>
						<td><input type="checkbox" id="post-menu-enable"  name="linkedin" <?php if($ShareButtons->linkedin == 1){echo "checked";} ?> value="1"  /> <b>LinkedIn</b> </td>
						<td><input type="checkbox" id="post-menu-enable"  name="digg" <?php if($ShareButtons->digg == 1){echo "checked";} ?> value="1"  /> <b>Digg</b> </td>
						<td><input type="checkbox" id="post-menu-enable"  name="delicious" <?php if($ShareButtons->delicious == 1){echo "checked";} ?> value="1"  /> <b>Delicious</b></td>
					</tr>
					<tr>			
						<td colspan="3" ><input type="checkbox" id="post-menu-enable"  name="reddit" <?php if($ShareButtons->reddit == 1){echo "checked";} ?> value="1"  /> <b>Reddit</b></td>
					</tr>
				
				</table>				
				<input  class="submit"  type="submit" value="Update" />				
				<input type="hidden" name="send_options" value="1" />
			</form>
		</p>
		</div>

		<div id="metadata_window">
		<p>
			<b>credits</b><br/>
			author: <a target="_blank" href="http://hemk.es/" title="Nico Hemkes">Nico Hemkes</a>
			<br/>
			github: <a href="https://github.com/turbopixel/GetSimple-Plugins" target="_blank" >getsimple plugins</a>
			<br/>
			<a target="_blank" href="http://get-simple.info/extend/plugin/sharebar/500/" title="more details">GetSimple - Sharebar Details</a><br/>
			<a href="http://www.iconfinder.com/search/?q=iconset%3Asocialnetworking"  target="_blank" title="Iconfinder">Socialnetworking</a> icon set. (License: CC BY-SA 3.0)<br/>
		</p>
	</div>
	<?php
	
}

/**
 * frontend - insert css
 * @return echo html
 */
function sharebar_header(){
	global $SITEURL;

	echo '
<!-- sharebar plugin (http://get-simple.info/extend/plugin/sharebar/500/) -->
<link rel="stylesheet" media="all" href="' . $SITEURL . 'plugins/sharebar/sharebar.css" >
	';

}

/**
 * frontend - insert social share buttons below the content
 * @return echo html
 */
function sharebar_content() {
	global $ShareButtons, $SITEURL, $sharebarButtons;
	
	// -- get data
	$button_line 	= (int)$ShareButtons->active;
	$fb 			= (int)$ShareButtons->facebook;
	$tw 			= (int)$ShareButtons->twitter;
	$gp 			= (int)$ShareButtons->gplus;
	$li 			= (int)$ShareButtons->linkedin;
	$dg				= (int)$ShareButtons->digg;
	$dl				= (int)$ShareButtons->delicious;
	$rd				= (int)$ShareButtons->reddit;
	$at				= (int)$ShareButtons->author;
	$extent			= (int)$ShareButtons->extent;

	// -- get button size
	foreach( $sharebarButtons AS $btn ){
		if( $extent == $btn['id'] )
			$size = $btn['size'];
		else
			continue;
	}

	// -- site url link
	$shareUrl = get_page_url(TRUE);
	
	// -- active? -> show it!
	if($button_line == 1){
		echo "<div style='clear: both;'></div><div id='sharebuttons'>";

			# facebook
			if( $fb === 1) {
					echo '<a href="https://www.facebook.com/sharer.php?u=' . $shareUrl . '" target="_blank" title="Share on Facebook" rel="nofollow" >';
					echo '<img width="' . $size . '" height="' . $size . '"  src="' . $SITEURL . 'plugins/sharebar/facebook.png" />';
					echo '</a>';
			}

			# twitter
			if( $tw === 1) {
					echo '<a href="https://twitter.com/share?url=' . $shareUrl . '" target="_blank" title="Share on Twitter" rel="nofollow" >';
					echo '<img width="' . $size . '" height="' . $size . '"  src="' . $SITEURL . 'plugins/sharebar/twitter.png" alt="Twitter" />';
					echo '</a>';
			}

			# googleplus
			if( $gp === 1) {
					echo '<a href="https://plus.google.com/share?url=' . $shareUrl . '" target="_blank" title="Share on Google+" rel="nofollow" >';
					echo '<img width="' . $size . '" height="' . $size . '" src="' . $SITEURL . 'plugins/sharebar/googleplus.png" alt="G+"/>';
					echo '</a>';
			}

			# linkedin
			if( $li === 1) {
					echo '<a href="http://www.linkedin.com/shareArticle?mini=true&url=' . $shareUrl . '" target="_blank" title="Share on LinkedIn" rel="nofollow" >';
					echo '<img width="' . $size . '" height="' . $size . '"  src="' . $SITEURL . 'plugins/sharebar/linkedin.png" alt="LinkedIn" />';
					echo '</a>';
			}

			# digg
			if( $dg === 1) {
					echo '<a href="http://digg.com/submit?url=' . $shareUrl . '" target="_blank" title="Share on Digg" rel="nofollow" >';
					echo '<img width="' . $size . '" height="' . $size . '"  src="' . $SITEURL . 'plugins/sharebar/digg.png" alt="Digg" />';
					echo '</a>';
			}

			# delicious
			if( $dl === 1) {
					echo '<a href="http://del.icio.us/post?url=' . $shareUrl . '" target="_blank" title="Share on delicious" rel="nofollow" >';
					echo '<img width="' . $size . '" height="' . $size . '"  src="' . $SITEURL . 'plugins/sharebar/delicious.png" alt="Digg" />';
					echo '</a>';
			}

			# reddit
			if( $rd === 1) {
					echo '<a href="http://reddit.com/submit?url=' . $shareUrl . '" target="_blank" title="Share on ReddIt" rel="nofollow" >';
					echo '<img width="' . $size . '" height="' . $size . '"  src="' . $SITEURL . 'plugins/sharebar/reddit.png" alt="Digg" />';
					echo '</a>';
			}

		echo "</div>";
	}
}

?>