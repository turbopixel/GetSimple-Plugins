<?php
/*
Plugin Name: Sharebar
Description: This extension include ten social media icons below the content for more sharing. Only HTML Buttons - compliance with data protection.
Version: 1.1
Author: Nico Hemkes
Author URI: http://www.nokes.de/
*/

$thisfile = basename(__FILE__, '.php');
$config_file = GSDATAOTHERPATH . 'nokes_sharebar.xml';

register_plugin(
	$thisfile, 									
	'Sharebar',									
	'1.2.1', 										
	'Nico Hemkes', 								
	'http://www.nokes.de/', 					
	'Add html share icons above the content area. Only HTML Buttons - compliance with data protection', 
	'settings',									
	'button_options'							
);

if( file_exists( $config_file ) ) {
	$buttons = simplexml_load_file( $config_file );
} else {
	$buttons = new simpleXMLElement( '<channel></channel>' );
	$buttons->addChild( 'active', '0' );
	$buttons->addChild( 'facebook', '0' );
	$buttons->addChild( 'twitter', '0' );
	$buttons->addChild( 'gplus', '0' );
	$buttons->addChild( 'linkedin', '0' );
	$buttons->addChild( 'digg', '0' );
	$buttons->addChild( 'delicious', '0' );
	$buttons->addChild( 'stumbleupon', '0' );
	$buttons->addChild( 'reddit', '0' );
	$buttons->addChild( 'technorati', '0' );
	$buttons->addChild( 'author', '1' );
	$buttons->addChild( 'extent', '3' );
	$buttons->asXML( $config_file );
}

add_action( 'settings-sidebar','createSideMenu',array( $thisfile, 'Sharebar' ) );
add_action( 'content-bottom', 'sharebar_content', array() );
add_action( 'theme-header', 'sharebar_header', array() );

function button_options() {
	global $buttons, $config_file;
	
	if( $_POST['send_options'] == 1 ) {
		$button_active		=	htmlentities($_POST['active']);
		$button_facebook	=	htmlentities($_POST['facebook']);
		$button_twitter		=	htmlentities($_POST['twitter']);
		$button_gplus		=	htmlentities($_POST['gplus']);
		$button_linkedin	=	htmlentities($_POST['linkedin']);
		$button_digg		=	htmlentities($_POST['digg']);
		$button_delicious	=	htmlentities($_POST['delicious']);
		$button_stumbleupon	=	htmlentities($_POST['stumbleupon']);
		$button_reddit		=	htmlentities($_POST['reddit']);
		$button_technorati	=	htmlentities($_POST['technorati']);
		$button_author		=	htmlentities($_POST['author']);
		$button_extent		=	htmlentities($_POST['extent']);
		
		$buttons->active = $button_active;
		$buttons->facebook = $button_facebook;
		$buttons->twitter = $button_twitter;
		$buttons->gplus = $button_gplus;
		$buttons->linkedin = $button_linkedin;
		$buttons->digg = $button_digg;
		$buttons->delicious = $button_delicious;
		$buttons->stumbleupon = $button_stumbleupon;
		$buttons->reddit = $button_reddit;
		$buttons->technorati = $button_technorati;
		$buttons->author = $button_author;
		$buttons->extent = $button_extent;
		$buttons->asXML( $config_file );
		
		$note = '<p class="updated">Updates successful.</p>';
	
	}
	
	switch($buttons->extent){
		case 1: $a = ' selected="selected" '; break;
		case 2: $b =  'selected="selected" '; break;
		case 3: $c =  'selected="selected" '; break;
		case 4: $d =  'selected="selected" '; break;
		case 5: $e =  'selected="selected" '; break;
	}
	?>
		<h3>Sharebar Options</h3>
		<?php echo( $note ); ?>
		<p>
			<form method="post" action="<?php echo $_SERVER ['REQUEST_URI']; ?>">
			<div id="metadata_window">
				<input type="checkbox" id="post-menu-enable"  name="active" value="1" <?php if($buttons->active == 1){echo "checked";} ?> /> <b>Display Icons</b>
				<br/>
				<br/>				
				<label for="code">Button size</label>
				<select class="text " style="width: 200px;" name="extent">
					<option value="1" <?php echo $a; ?> >14x14px</option>
					<option value="2" <?php echo $b;?>>16x16px</option>
					<option value="3" <?php echo $c;?>>20x20px</option>
					<option value="4" <?php echo $d;?>>22x22px</option>
					<option value="5" <?php echo $e;?>>24x24px</option>
				</select>
				<br/>
				<br/>
				<h3>Sharebuttons</h3>				
				<table cellpadding="0" cellspacing="0">
				
					<tr>
						<td><input type="checkbox" id="post-menu-enable"  name="facebook" <?php if($buttons->facebook == 1){echo "checked";} ?> value="1"  /> <b>Facebook</b></td>
						<td><input type="checkbox" id="post-menu-enable"  name="twitter" <?php if($buttons->twitter == 1){echo "checked";} ?> value="1"  /> <b>Twitter</b></td>						
						<td><input type="checkbox" id="post-menu-enable"  name="gplus" <?php if($buttons->gplus == 1){echo "checked";} ?> value="1"  /> <b>Google+</b> </td>
					</tr>
					<tr>
						<td><input type="checkbox" id="post-menu-enable"  name="linkedin" <?php if($buttons->linkedin == 1){echo "checked";} ?> value="1"  /> <b>LinkedIn</b> </td>
						<td><input type="checkbox" id="post-menu-enable"  name="digg" <?php if($buttons->digg == 1){echo "checked";} ?> value="1"  /> <b>Digg</b> </td>
						<td><input type="checkbox" id="post-menu-enable"  name="delicious" <?php if($buttons->delicious == 1){echo "checked";} ?> value="1"  /> <b>Delicious</b></td>
					</tr>
					<tr>
						
						<td><input type="checkbox" id="post-menu-enable"  name="stumbleupon" <?php if($buttons->stumbleupon == 1){echo "checked";} ?> value="1"  /> <b>Stumbleupon</b></td>
						<td><input type="checkbox" id="post-menu-enable"  name="reddit" <?php if($buttons->reddit == 1){echo "checked";} ?> value="1"  /> <b>Reddit</b></td>
						<td><input type="checkbox" id="post-menu-enable"  name="technorati" <?php if($buttons->technorati == 1){echo "checked";} ?> value="1"  /> <b>Technorati</b></td>
					</tr>
				
				</table>				
				<input  class="submit"  type="submit" value="Update" />				
				<input type="hidden" name="send_options" value="1" />
			</form>
		</p>
		</div>

		<div id="metadata_window">
		<p>
			<b>Credits</b><br/>
			<a href="http://www.iconfinder.com/search/?q=iconset%3Asocialnetworking"  target="_blank" title="Iconfinder">Socialnetworking</a> icon set. (License: CC BY-SA 3.0)<br/>
			Plugin by <a target="_blank" href="http://www.nokes.de/" title="Nico Hemkes">Nico Hemkes</a> / 	<a target="_blank" href="http://www.nokes.de/getsimple-plugin-sharebar.html" title="Sharebar Detail Page">Plugin Details</a> <a target="_blank" href="http://www.nokes.de/getsimple-plugin-sharebar-englisch.html" title="Sharebar Detail Page">(Englisch)</a><br/>
			</p>
		</div>
	<?php
	
}

function sharebar_header(){
	echo "
	
<!-- 
	Getsimple CMS - Sharebar Plugin 
	Full Details: http://www.nokes.de/getsimple-plugin-sharebar.html
-->
<style type='text/css'>
	#sharebuttons{
		margin: 10px 0;
		padding: 20px 20px 0;
		background:  url(data:;base64,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) no-repeat left top;
	}
	#sharebuttons img{margin: 0 4px 0 0;}
	#sharebuttons small{
		font-size: 8px;
		color: #555;
		text-decoration: none;
	}
</style>	

	";
}

function sharebar_content() {
	global $buttons;
	
	$button_line 	= (int) $buttons->active;
	$fb 			= (int) $buttons->facebook;
	$tw 			= (int) $buttons->twitter;
	$gp 			= (int) $buttons->gplus;
	$li 			= (int) $buttons->linkedin;
	$dg				= (int) $buttons->digg;
	$dl				= (int) $buttons->delicious;
	$so				= (int) $buttons->stumbleupon;
	$rd				= (int) $buttons->reddit;
	$th				= (int) $buttons->technorati;
	$at				= (int) $buttons->author;
	$extent			= (int) $buttons->extent;
	

	switch($extent){
		case 1: $size = 14; break;
		case 2: $size = 16; break;
		case 3: $size = 20; break;
		case 4: $size = 22; break;
		case 5: $size = 24; break;
	}
	
	if($button_line == 1){
		echo "<div style='clear: both;'></div><div id='sharebuttons'>";
			if( $fb === 1) {
					echo '<a href="http://www.facebook.com/sharer.php?u=' .rawurldecode("http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI] ) . '" target="_blank" title="Share on Facebook">';
					echo '<img width="' . $size . '" height="' . $size . '"  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNAay06AAAAAVdEVYdENyZWF0aW9uIFRpbWUANi8yNC8wOfbBa+MAAAK6SURBVFiFvZbNaxNRFMV/701Sa/xIuykiESpYiy5dWdeCO0VBUOpO3bjwYyHqRoIbcaW48A9QRKiCCiL6H7hxpaJSxSiFom1j0jaZpJm510VI7GRixjoT7+pd7nDOmXvuuzNGVTHGcOLyk/MiklfVLH0MY0zZWpu/d/3QLQCjqkxeenze9/2bqZTDpmyGgcE0xrGJEqsvrNQaLJWreJ6P4zgX7t84fCsF4Pte3rGWka3DrNQaVBZriC+JCrCOZXB9mpGtw3yfWcD3vTzQEiDZTUMbKRddfM9PlLgVIsJyo45T9chszlBaWMwCpABUBYyl0VjpC3lASMNjXXqgydkSINL0R1VjgbsVl2rVpThXDNXGdu9on1dqDURWCVAVvJitL84V2b5lA3smxjl1bCJUn7zytH0Wzw93QGK8vVt1ObJ/nNPH9v3xmU78YAdEUfl3ATtz2Z7kLY5uebMDKsTgZ2zbUOQznfiSpAUnOzz3fGHqxTs+fivx7vNcd0GdQxjnBlhjAnnKsXz4+vOP5C3OtgARQeJ40CXeTP/oWe8YwrVbMPOp0LP+bfpLIM/tGA3kulqA/IMFr59dXFP94LmpQB4cQo03hH8ToT2gHXtAkv34hQV04Af3gMS7BSEy1cDNuP/8bQg/dA3XasGBMw/a55d3jgdq1phAvVsk+i3oFlF4gQ4kbQEQiRe2IOFFFIXXxYJE+SPxghaoUqtUExUQhdeakRRAZtBhdFcuUQHjEXiF9wu/BagodTfZH9IovNYistAciLpbSVRAr6i7lfYQWgBjHVkqzf83AUulebCOAFhjjDHpzF23UmZ+tkDdXe4bcd1dZn62gFspY9KZu8YYY4ABYHjv0Wu3LeaoimcicGKFsSkV1YevHl09C/w0QAbIARv6SdwlKsBMCvCAMlBfLbRPpKvXUw3wfgHbjK5YKpwWrgAAAABJRU5ErkJggg%3D%3D" />';
					echo '</a>';
				}
			if( $tw === 1) {
					echo '<a href="http://twitter.com/share?url=' .rawurldecode("http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI] ) . '" target="_blank" title="Share on Twitter">';
					echo '<img width="' . $size . '" height="' . $size . '"  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABV0RVh0Q3JlYXRpb24gVGltZQA2LzI0LzA59sFr4wAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNAay06AAAAOaSURBVFiFvZfPa1xVFMc/b+b9mHSSSV9izCRpbEmNilbjqgsL0oW6EBSKQl1ZFJEuCtadK/8BFyq4EBeFuhB/bEqEImajiAiCoJZiMBKrSYw4MdNkMpm+effe42Jmwkxn3p10nPbAg+HOeed87jnnfu+MIyI4jgPAhStX386E4Qsp389zG8xUq3/fKBY/funYg6831pwGwMVrK796BwZm7wkCRtw0XirV1+SxMWwqzZ9RRLxbWXrx8KH79gA++OnKO9mJidcezR6gbAzbShOL9BXAcxxybppsKsWP5V3K6+vvvjr38PkUgBuOnJ4OAtZjRSFWRCIY6OsTiVCIFeuxYjoIcMOR0wAuAH6QF6CiTV933ckq2uC5afCD/B6AEkNJawz9LXuSlbRGSW2zLoARUCY5+dLSKh99uEA1quIHPqeef5xH5o72DKBEaKRzATTGuvtPPvsWJ3c3geOACPOXf+DY3EzPAI2cewDKgKUAmIEQ6loBYFyPldV/mZoa7RlA1cetXgGwjp/vty0NDWbs73QxTTOAEcR27j2vbengcPZ/aYWul7xeAbHuxukA8OZblxL9/cDluWePM3N4LBmAJgAl9hnAbQcIJo4k+4tw6curnH/lZKKLaj4FRgSxaUCHCnQz491ljWmkuQJdWtALwICXtsZUrS2QPaKO1qEF3ZKfPTGJssRUzRXQ0uUYdqjA+6eSlVCL8EcUUbXcLbpFCUWwnqgOAD/v7Fpe6G5a2o7hrbXgl5Xr3D893DtAywx0kWK8diX8avEfxHHIeLUbfTwMCLz0vgFapDiWbqfAbVuSkTwLiwXE1ERV4iqYWpRsJs2Jh8aZnRhMDBk3t8CIXYpHBwM2o/bv/fHpjv5KxXyzvMm9+WxizFvSgScm03y66lg8Ws3xPCSTwVBN9GnVAWPXgamc4vjYAN8X9w8R+mAkSgYwNwuRJVghVjyVr3J0KOCLDZdibAcJPeHMVMSGSvZRrTMAW7Em5yZP8e+ViLFA88aMj+/YAaoi/Fa5kagt20rf9JOsXCruZPxwEPufkUIcU4hjq89+bMdodLlUBGoZ02tr88uViJIymPrVfLuekjIsVyLSa2vzAE79cZ/5+rtrhKOThwKPYdfloKUdvdh1pdlSitUohs2Nvz4/+dgRQDmABwwB3tMXLr5nZh94UnK53jXWYs729lZqaXHh8stnzgExUGoBoFaNO2HSDOBQG8bG5zsFIID6D4Ek7cRpQpS6AAAAAElFTkSuQmCC" alt="Twitter" />';
					echo '</a>';
			}
			if( $gp === 1) {
					echo '<a href="https://plus.google.com/share?url=' .rawurldecode("http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI] ) . '" target="_blank" title="Share on Google+">';
					echo '<img width="' . $size . '" height="' . $size . '" src="data:image/png;base64,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%3D" alt="G+"/>';
					echo '</a>';
				}
			if( $li === 1) {
					echo '<a href="http://www.linkedin.com/shareArticle?mini=true&url=' .rawurldecode("http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI] ) . '" target="_blank" title="Share on LinkedIn">';
					echo '<img width="' . $size . '" height="' . $size . '"  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABV0RVh0Q3JlYXRpb24gVGltZQA2LzI0LzA59sFr4wAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNAay06AAAAN6SURBVFiFvZdNaFxVGIafc+/MJJnaJGXSNGlGW1JGaOsfFkTEbooLFVFQQSnJQoJddSGI4A/VRfFn405QFHERAgZUEMG6kIJIqm5KNbYU0w6NDY2JM00mw8x17pwfF/He3DtzM5nYm3xw4cx5v3O+557vPTOMIBDPf/b9OwYzijFZtiKEmBOI8c9feOR1f8obPPvJd78LIQ7f0Z+hv3sHqYQVa21XahZXKvy5WMQYc/GLFx+9ywd4+uNv3wVevT+3j1JNU6i6uErHCpCyLfrSKXo6LM7PzAK899WJx19LAMi6HNk/sJv8TYdqXcVa2AtHaa67kmLSJpvZxbW//h4BVgGUUlkpbMr/1EOLqsUFlmdnAOjdlyOd2XPLIOWaprPTRimVBfAAWKopVMOxH0w6jI09AcCnP1wgH1NblmqrNdcApKZak02JJ44dCY1fObcQC0BVaZTUAQDV/PYAlhW+CVE5/zfCJ6AUSjdvPnF5idFDGQDGLxUjc2IC0JFvNzW3wtTcSmxFwwBttKAw/XPoc9/dDwJQr6xQyl/y59P9QyRv66G6cJ16pezPp7p3kd5zO4nOdARAGy048+ZY6PPxL6cBODjQy1sja9rE1DQXrswy+sxR7tk/6M+fu3yNiR9/pcAQdqqjFUB0C9YzYdXYIe2hXJbRo/c2rX/40DD3DQ9xcvwsFXsgci/LP4H/IIKPZVmhx5u/WqiE5nN7dzflek93uovjD+Qi9g+cgNY6sgW2bYepAzmNWr5Q5vTZPwA4dexOhvt2+tqRA1nUb0uhfK2DJyA3dwJR2ke/zHKj5HCj5PDhT/mQtjfT07y/DHpAR5uwyQOBnEbt/NxNfzxTrLRc69X0AfQ6JmxqgVq/BUGtVHVb6l5NH2Czt2AjrR09/EUkpe/KYDS/hWpLa0dXUgYAtEa24QHZwgON6zfSPU/4ANvegiCAlpv/Ob5VAN3ONWyMVjkbrV/vGgqAzHNvmOTggQ0B4oz6/FWKk28L3wPCqSBSXdtS3LhOgwe0mReuM6gSHS0XxhW266C1mV8DMEw6y8WXLLsDscUQRtZwl4sgxCSsekAAia4nX74IImft6IVUV+ztMK4DroOuLIMxM8437x8GpACSwE4gmXrs5GlhJZ4C0x9rdT/EotHya/fMB6eAOlAOARD4s7rFYYIAglUveOPtAjCA/Bfknj2Vx2kPiQAAAABJRU5ErkJggg%3D%3D" alt="LinkedIn" />';
					echo '</a>';
			}
			if( $dg === 1) {
					echo '<a href="http://digg.com/submit?url=' .rawurldecode("http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI] ) . '" target="_blank" title="Share on Digg">';
					echo '<img width="' . $size . '" height="' . $size . '"  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABV0RVh0Q3JlYXRpb24gVGltZQA2LzI0LzA59sFr4wAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNAay06AAAALUSURBVFiFvZc7aBRRFIa/OzO7JkbFKAkmxIiCoGihpWBjlULBUsRYpLCx8UHAB1oJGjHYCJZKEkVSKlrEJr2FWBgUAj7ik5XERM1usjP3jMU6k3tnd5OYzO4PA+f+nDnnn3PO3DujMNDTP3IdwpNhGHZQAyilPoMaut/bdTnmIuPkzWevlVJ7tm7ZTEtzE1nPTTV5MdD8+DnLp++ThGE4NnTh8N5YQHff0xvAxX27tvGrIEz9macYSKoCsp7DpnVr2NDo8OrtR4C+BxePXPIAAt/v7mxv5UMuT6GoU00coaCFL/MBU1mX9pZmJr7muoGSAK11h+AwO+fXJLmJ2TmhoclFa90BUBIgwnRBoyXdslfDdIE4V1QBCvNBXZJDqR1aa1OA1O3pI2htVEAkQBYRMPF+HIDO7TstezUQCRYELFWBgavHAbg8+MKyVwOrAlpLTFSC5zrxTaadmoBKLfg68W5BgHOQkp9w7MogAO2dOyyfCIvxJpZswZObPeWqRWL+1J3Rij6L8VYsqwVSLiAqdVJA3ALDruaT5CutHQDRGtFiXZ6r8FxF962R2Db55fgkefsy9wEp3wUrPelqbbsChgARKRvC6Mbclw+xLUZA067mk+RNiLkVS4UhzLilT4WX985YfYt4067mk+QtAfYQ6rL3uuIgJfaBpXySvLUW6ywon4ED5x6VBUnyu0/0x/abh73/AktV3ha0xAwsB1FwEyJSla+0jgWkdRpWi1M2A8nvgZXs7ftPD/wXbwlKowWrQc1asCIBWgv+XB4n01Cf5P6cfRiFoXzDz7eJm62LAPx8KWckQEI1PDszeTbrNOB4tRUhQZHizCRKOcNQ+jNSgNfWdX4M2Omu3YiTbcTJNKab2C8gxQI6Pw0h49+e394DBArIAOuBTOuh09eU4x0FWlPNvoBcKMHj3Ojdq4AP/LYEYPys1hihKUBRmoXIrpeAEAj+AuDDE08z88hqAAAAAElFTkSuQmCC" alt="Digg" />';
					echo '</a>';
			}
			if( $dl === 1) {
					echo '<a href="http://del.icio.us/post?url=' .rawurldecode("http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI] ) . '" target="_blank" title="Share on delicious">';
					echo '<img width="' . $size . '" height="' . $size . '"  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABV0RVh0Q3JlYXRpb24gVGltZQA2LzI0LzA59sFr4wAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNAay06AAAAKxSURBVFiF1Ze9a1NRGMZ/596bT5tgUwoWOjjo1Lo6CS7Ozg5q3Sy6uCpIcbF7/Q8Uh64ODgqCUPzapKlUtHRooaShfqRpk9zcc16Hm3vTWGjvuQ2CD2Q773N+532fc5IoEUEpBcDKl6+PReSGCJMk1IWHn2FkItlipTZBPePppQcAIoKKAJarq1WlmCoWT1EsFnBdB4U60q9cHuHy3FsKlWS87XaXrZ1d1uv7Kzy/Mi0ieADL1dV5YKpSGaNQyCNGMGIQOdpQgPff96C0mwggn3GYKOe5eFamPl17OQ/c9wC01tdLpRL5XA6tDXLczgelfQg6iZa2A1hvQd1pcW7MvRUDGK0ns9ksRgRjTPLNpQeg/eQ1QNPXdLzOGSAcgRGD53kYY3l6BIwPOlkH+mVC/WeDPoAxKKXsTh9JpwAA2q39gwBiefJQEgEkzMCAejW9DASIpDi9COiudQaAuCbOQJoOhEbDALAOXyiBdCH8G8D67scEEm6eCuBABuR/HUFslOYWRABKKV69fsP4eMXaQ5DQaK9mD9D+EQIA3L1zm1wuZ28CND98TFW3tPSuD+C6LplMxtrE98M21us71rXRuxNnIM0zHGUnzSMW7RcDaK2tTaKaNAE+BJCmA+HG6b5HjNEnBwhHkLYD0gfQWv/zEQyEUGx/CfUU1qQbgdZDykD6EQzpGkYgtjr0DnS7XRzHsTIJM2A/gmazORhCY8yW1nrC8zyCIEhs1B+BXfcajd+AbMUAIrIYBME9IP6blkRpQthqtajVariuuwigep/M6OhoFTjvOA6O4yQC0VqztrbGxsbmsWubzSaNRoPt7W2MMd9mZm5OA10FZIHTQK5cLs8ppa6KyHiS0xhjWFh4kmRppLrvd17Mzs4+AjrArwEAG6chKAZQQAawuwInlwG6fwC6iOGzX5PqugAAAABJRU5ErkJggg%3D%3D" alt="Digg" />';
					echo '</a>';
			}
			if( $so === 1) {
					echo '<a href="http://www.stumbleupon.com/submit?url=' .rawurldecode("http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI] ) . '" target="_blank" title="Share on stumbleupon">';
					echo '<img width="' . $size . '" height="' . $size . '"  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABV0RVh0Q3JlYXRpb24gVGltZQA2LzI0LzA59sFr4wAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNAay06AAAASKSURBVFiFvZdLbBtFGMf/M7tZP+I4TmI7TZUmUqtWrUIRCoELikAq4dESgnJLSdUDQqSUVhDBoRWPAyI9IaEeEUJCIKAXpFwrHodKgKiSIpUgmkYqaUKch038qu31zszHwV5713kQkJtP+jQzO579fjPfY7wMDjlx7cUJEE6B0Ik6ymu5UQCAYHzl5eKRT2OD+y7ac8zuHP/+5G9NemPP3ua98Hm99bSPk9YgAMA0TYwuh7Fu0UxsqPsBANAB4JlvRy75mb8n0taORbkCq2DVFUCQAADouo49kTBoba2nY3L+Umyo+wIHAGWp0ZC/GQvFJRRlEaSorqppGjRNA+ccs0UdrYFGgOhs5QRIyM4ErYOkquvObeEGd41jZABSNFUApCQUSYBJtsnyOgBwN0CRGwARKgAkCCCAJO0KADgH4ABQkqDuk3EA0DStOpClgCRhVQFIqA27N+N5mMkCoHYGxnQOb9SPhoCxYc55ArZhsooOAEkuADORxwutA9lnHzrW4NENz04A0oVM9pPfv9RvJma9RshdR1wuKJ+A3ZbSUCgoWdXh8NOZ4UMnAj7D6+GcYyca8jcH3uw7430y8JjpfJeSyvU7klZFXQD2KZAkDHQ9Tjs1XKvDB46bzneRpM0BhNMF5YJhS6ixOWj3P76TMa8XtnfDKxG52hf2R+21VBM3riAUZrl1ANRmgdNni8sr+HFurTrnawRviYD5GivPnvDI4qPRQGVcm1GuILSzoNxW6gBtATDRf9gz0X+4Mr61llz94Jc70amMVYFgxGqMbA2AchbYLS8tcMfA/L2/Elv5+Eh7a/SLwYfR5zFBUoCkAEOtn7eLgdIacgLYLrD17akP2+7mluL2JbKZvnG0IwZpAdICY3DN1b7POWevgdxQiKoXUVZmce7au+H9wS60+yMIGoE8AIzsfz4bDYQjANAZ9Bsk4yUX1ByzsiQYL90rJNS/x4BSBLVJxZtLzmMuOQ8APlWUyCdyvovHzgMA9rU2t9l+VJpuOI0YeR2mT4AUoaUQ2DYGdADILaRBYvur+FD0AF56ZCTBOW8DgLl4apGk1QkAP8TS0bEHq0ae6ug3v5r6xhPwNOKt584kOechAEjmCymSVnPpZMoApmlienoavb292wKUpc3uTP+d89q7mImnXbk+PjDmGR8Ys4chu3N97V4BogRQyQLOORhj/6naCUL+oxt/hu2ITuUL+PrWUny7NZZS+fd+mm2vZIEdA5xzENHGO3sL+XkpsXz26o09C+mc6/n4d7+G1wvF1Omj3SpoNLQ45/5IZFZevTrdvpBMVx+Ws4ABQPDcBOldB3cEUC8Rd28jdfkC40RUuhqd+bkr6izFUkDlMmAe367snsy8uw5Aihhl0x1M03cHIJsGpIhVAaCuUCr+uvIYYA07+gP0/41bJigVBxi7ApSCkAHQA6fOzwA4yAMhMK8PzFPfzzMyC6BCHiqbBIDb2c8v9wAQDEADgCYADf6h0+9D04YYIVpX6zYEwyqknMxNfvYOAAtAxgUAx8fqfRZyAjCUYsHu7xYAARD/AGMU8w0aGGzCAAAAAElFTkSuQmCC" alt="Digg" />';
					echo '</a>';
			}
			if( $rd === 1) {
					echo '<a href="http://reddit.com/submit?url=' .rawurldecode("http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI] ) . '" target="_blank" title="Share on ReddIt">';
					echo '<img width="' . $size . '" height="' . $size . '"  src="data:image/png;base64,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%3D%3D" alt="Digg" />';
					echo '</a>';
			}
			if( $th === 1) {
					echo '<a href="http://technorati.com/faves?add=' .rawurldecode("http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI] ) . '" target="_blank" title="Share on Technorati">';
					echo '<img width="' . $size . '" height="' . $size . '"  src="data:image/png;base64,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%3D%3D" alt="Digg" />';
					echo '</a>';
			}
			
			
			// -- PLEASE DON'T REMOVE THIS LINK !
			print '<br/><a href="http://www.nokes.de/getsimple-plugin-sharebar.html" title="Sharebar Plugin Details" target="_blank" style="font-size: 8px !important;" >sharebar plugin</a>';
			// -- PLEASE DON'T REMOVE THIS LINK !
					
			
			
		echo "</div>";
	}
}


?>