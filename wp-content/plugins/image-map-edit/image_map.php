<?php
/*
Plugin name: Image Map Edit
Plugin URI: http://www.clickablemaps.net
Description: Edit and place Clickable Image Maps through easy to use shortcodes
Version: 1.0
Author: Gordon Farmer
Author URI: http://www.cartzone.co.uk
Additional Contributors: Elian Ibaj
Copyright 2013 cartZone UK www.cartzone.co.uk

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

function image_map_maps_list() {
	return array( 'estonia' => 'Estonia');
	//return array( 'europe' => 'Europe','world' => 'World');
}
// No need to edit below this line

function image_map_enqueue_styles() {
    wp_register_style( 'maphilight_style', plugins_url('/css/style.css', __FILE__) );
	wp_enqueue_style( 'maphilight_style' );
}

function image_map_enqueue_scripts() {
	wp_enqueue_script('jquery');
    wp_register_script( 'jquery-metadata', plugins_url('/js/jquery.metadata.min.js', __FILE__) );
    wp_register_script( 'jquery-maphilight', plugins_url('/js/jquery.maphilight.js', __FILE__) );
    wp_register_script( 'easyTooltip', plugins_url('/js/easyTooltip.js', __FILE__) );
	
    wp_enqueue_script( 'jquery-metadata', array('jquery') );
    wp_enqueue_script( 'jquery-maphilight', array('jquery') );
    wp_enqueue_script( 'easyTooltip', array('jquery') );
}


add_action( 'wp_enqueue_scripts', 'image_map_enqueue_styles' );
add_action( 'wp_enqueue_scripts', 'image_map_enqueue_scripts' );
add_action('wp_head', 'image_map_dynamic_scripts');

function image_map_enqueue_color_picker() {
    wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'image-map-admin', plugins_url('js/admin.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}
add_action( 'admin_enqueue_scripts', 'image_map_enqueue_color_picker' );

add_action('admin_menu', 'image_map_menu');

function image_map_menu() {
	add_menu_page('Image Maps', 'Image Maps', 'manage_options', 'image_map', 'image_map_options');
	add_submenu_page( 'image_map', 'Edit Map Links', 'Edit Map Links', 'manage_options', 'image_map', 'image_map_options');
	add_submenu_page( 'image_map', 'Map Customizations', 'Map Customizations', 'manage_options', 'image_map_options', 'image_map_options_page');
}

function image_map_load_maps() {
	$maps_list = image_map_maps_list();
	foreach ($maps_list as $map_id=>$map_name) {
	$map = file( dirname(__FILE__) . "/{$map_id}.php");
	$areas = array();
	$matches = array();

	foreach($map as $line) {
		if (substr(trim($line), 0, 5) == '<area') {
			$line = preg_replace('/<area(.*)href="([^"]*)"(.*)>/','<area$1href="{link}"$3>',$line);
			preg_match('/(<area[^>]+?title=[\'"])([^\'"]*?)([\'"][^>]+?>)/', $line, $matches);
			$title = $matches[2];
			if (array_key_exists($title, $areas)) {
				$areas[$title] .= $line;
			} else {
				$areas[$title] = $line;
			}
		}
	}

	$maps[$map_id] = $areas;

	}
	return $maps;
}

function image_map_activation() {
	$default_options = array(
	'area-color' => '#000000',
	'area-opacity' => '0.9',
	'no-border' => 'on',
	'area-border-color' => '#ff0000',
	'area-border-width' => '1',
	'area-border-opacity' => '1',
	'no-shadow' => 'on',
	'shadow-color' => '#000000',
	'shadow-x' => '0',
	'shadow-y' => '0',
	'shadow-radius' => '6',
	'shadow-opacity' => '0.8',
	'tooltip-padding-horizontal' => '10',
	'tooltip-padding-vertical' => '5',
	'tooltip-color' => '#4642FF',
	'tooltip-border-color' => '#ffffff',
	'tooltip-border-width' => '1',
	'tooltip-text-color' => '#ffffff',
	'fade' => 'on',
	'alwaysOn' => 'false'
	);

	add_option('image_map_options', $default_options, '', 'yes');
}
register_activation_hook(__FILE__, 'image_map_activation');

function image_map_deactivation() {
	delete_option('image_map_options');
}
register_deactivation_hook(__FILE__, 'image_map_deactivation');

function image_map_dynamic_scripts() {
	$opt = get_option('image_map_options');
	echo '<script type="text/javascript">
	jQuery(function($) {
	$(".map").maphilight({' . PHP_EOL;

	if (isset($opt['no-area']) && !empty($opt['no-area'])) {
		echo 'fill: false,' . PHP_EOL;
	} else {
		echo 'fill: true,
		fillColor: "' . substr($opt['area-color'], 1) . '",
		fillOpacity: ' . $opt['area-opacity'] . ',' . PHP_EOL;
	}

	if (isset($opt['no-border']) && !empty($opt['no-border'])) {
		echo 'stroke: false,' . PHP_EOL;
	} else {
		echo 'stroke: true,
		strokeColor: "' . substr($opt['area-border-color'], 1) . '",
		strokeOpacity: ' . $opt['area-border-opacity'] . ',
		strokeWidth: ' . $opt['area-border-width'] . ',' . PHP_EOL;
	}
	if (!isset($opt['fade']) || $opt['fade'] != 'on' )	echo 'fade: false,' . PHP_EOL;
	if (isset($opt['always-on']) && $opt['always-on'] == 'on' )	echo 'alwaysOn: true,' . PHP_EOL;
	
	if (isset($opt['no-shadow']) && !empty($opt['no-shadow'])) {
		echo 'shadow: false,';
	} else {
		echo 'shadow: true,
		shadowX: ' . $opt['shadow-x'] . ',
		shadowY: ' . $opt['shadow-y'] . ',
		shadowRadius: ' . $opt['shadow-radius'] . ',
		shadowColor: "' . substr($opt['shadow-color'], 1) . '",
		shadowOpacity: ' . $opt['shadow-opacity'] . ',' . PHP_EOL;
	}
	echo 'last: false';
	echo '});
		$("map > area").easyTooltip();
	});
	</script>
	<style type="text/css">
	#easyTooltip{
		padding:' . $opt['tooltip-padding-vertical'] . 'px ' . $opt['tooltip-padding-horizontal'] . 'px;
		border:' . $opt['tooltip-border-width'] . 'px solid ' . $opt['tooltip-border-color'] . ';
		background:' . $opt['tooltip-color'] . ';
		color:' . $opt['tooltip-text-color'] . ';
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
		-webkit-box-shadow: 0 3px 3px rgba(0, 0, 0, 0.3);
		-moz-box-shadow: 0 3px 3px rgba(0, 0, 0, 0.3);
		box-shadow: 0 3px 3px rgba(0, 0, 0, 0.3);
		font:bold 13px / 16px "Lucida Grande",Arial,Sans-serif;
		/*line-height: 0px;*/
		z-index:100;
	}
	</style>';
}
/*HERE'S HOW TO ADD A BACKGROUND IMAGE TO THE TOOLTIP*/
/*background:' . $opt['tooltip-color'] . ' url(' . plugins_url( '/pin.png' , __FILE__ ) . ') left top no-repeat;*/

function image_map_options() {

$maps_list = image_map_maps_list();
$maps = image_map_load_maps();

if (isset($_POST['save'])) {
	$links = $_POST;
	unset($links['save']);
	update_option('image_map_links', $links);
}
$links = get_option('image_map_links');
?>

<div class="wrap">
<h2>Set Button Links</h2>
<p>Set the default links using the fields below. Leave a field blank if you don't need that area.</p>
<p>The links set here can be overwritten for each post with shortcodes like this:</p>
<p><code>[image_map new_york="http://en.wikipedia.org/wiki/New_York"]</code></p>
<p>Notice how for areas with multiple words you write the attribute in all lowercase and replace spaces with an underscore.</p>
<form method="post" action="">
	<?php foreach($maps_list as $id=>$title): ?>
	<?php $map = $maps[$id]; ?>
	<h3><?php echo $title; ?> <span>shortcode usage:</span> <code>[image_map id=<?php echo $id; ?>]</code></h3>
	<table class="form-table">
		<?php foreach($map as $link=>$arr): ?>
		<?php $link_safe = $id . '_' . str_replace(' ', '_', strtolower($link)); ?>
		<tr valign="top">
			<th scope="row"><label for="<?php echo $link_safe; ?>"><?php echo $link; ?></label></th>
			<td><input type="text" name="<?php echo $link_safe; ?>" id="<?php echo $link_safe; ?>" class="regular-text" value="<?php echo $links[$link_safe]; ?>"></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php endforeach; ?>
	<p class="submit"><input type="submit" class="button-primary" name="save" value="Save Changes"></p>
</form>
<?php
}

function image_map_options_page() {
if (isset($_POST['save'])) {
	$options = $_POST;
	unset($options['save']);
	update_option('image_map_options', $options);
}

$opt = get_option('image_map_options');

include('inc/admin_css.php');
?>

<div class="wrap">
<h2>Customizations</h2>
<div class="image_map_options">
	<form method="post" action="">
	<h3>Map Area</h3>
	<table class="form-table">
		<tr valign="top">
			<th scope="row">Fill Color</th>
			<td><label><input type="checkbox" name="no-area" id="no-area" <?php if (isset($opt['no-area']) && !empty($opt['no-area'])) echo 'checked="checked"' ?> > No Fill</label><br>
			<input type="text" value="<?php echo $opt['area-color']; ?>" name="area-color" id="area-color" /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="area-opacity">Fill Opacity ( from 0 - fully transparent to 1 - fully opaque)</label></th>
			<td><input type="number" value="<?php echo $opt['area-opacity']; ?>" step="0.1" min="0" max="1" name="area-opacity" id="area-opacity" /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="area-border-color">Border Color</label></th>
			<td><label><input type="checkbox" name="no-border" id="no-border" <?php if (isset($opt['no-border']) && !empty($opt['no-border'])) echo 'checked="checked"' ?> > No Border</label><br>
			<input type="text" value="<?php echo $opt['area-border-color']; ?>" name="area-border-color" id="area-border-color" /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="area-border-width">Border Width (in pixels)</label></th>
			<td><input type="number" value="<?php echo $opt['area-border-width']; ?>" step="1" min="0" max="20" name="area-border-width" id="area-border-width" /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="area-border-opacity">Border Opacity ( from 0 - fully transparent to 1 - fully opaque)</label></th>
			<td><input type="number" value="<?php echo $opt['area-border-opacity']; ?>" step="0.05" min="0" max="1" name="area-border-opacity" id="area-border-opacity" /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="shadow-color">Shadow Color</label></th>
			<td><label><input type="checkbox" name="no-shadow" id="no-shadow" <?php if (isset($opt['no-shadow']) && !empty($opt['no-shadow'])) echo 'checked="checked"' ?> > No Shadow</label><br>
			<input type="text" value="<?php echo $opt['shadow-color']; ?>" name="shadow-color" id="shadow-color" /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label>Shadow Position</label></th>
			<td><label>X axis: <input type="number" value="<?php echo $opt['shadow-x']; ?>" step="1" min="-50" max="50" name="shadow-x" id="shadow-x" /></label> <label>Y axis <input type="number" value="<?php echo $opt['shadow-y']; ?>" step="1" min="-50" max="50" name="shadow-y" id="shadow-y" /></label></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="shadow-radius">Shadow Radius</label></th>
			<td><input type="number" value="<?php echo $opt['shadow-radius']; ?>" step="1" min="0" max="50" name="shadow-radius" id="shadow-radius" /></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="shadow-opacity">Shadow Opacity</label></th>
			<td><input type="number" value="<?php echo $opt['shadow-opacity']; ?>" step="0.05" min="0" max="1" name="shadow-opacity" id="shadow-opacity" /></td>
		</tr>
	</table>
	<h3>Tooltip</h3>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label>Padding</label></th>
			<td><label>Horizontal: <input type="number" value="<?php echo $opt['tooltip-padding-horizontal']; ?>" step="1" min="0" max="50" name="tooltip-padding-horizontal" id="tooltip-padding-horizontal" /></label> <label>Vertical <input type="number" value="<?php echo $opt['tooltip-padding-vertical']; ?>" step="1" min="0" max="50" name="tooltip-padding-vertical" id="tooltip-padding-vertical" /></label></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="tooltip-color">Fill Color</label></th>
			<td><input type="text" value="<?php echo $opt['tooltip-color']; ?>" name="tooltip-color" id="tooltip-color"/></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="tooltip-border-color">Border Color</label></th>
			<td><input type="text" value="<?php echo $opt['tooltip-border-color']; ?>" name="tooltip-border-color" id="tooltip-border-color"/></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="tooltip-border-width">Border Width (in pixels)</label></th>
			<td><input type="number" value="<?php echo $opt['tooltip-border-width']; ?>" step="1" min="0" max="10" name="tooltip-border-width" id="tooltip-border-width"/></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="tooltip-text-color">Text Color</label></th>
			<td><input type="text" value="<?php echo $opt['tooltip-text-color']; ?>" name="tooltip-text-color" id="tooltip-text-color"/></td>
		</tr>
	</table>
	<h3>Miscellaneous</h3>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label>Fade Effect</label></th>
			<td><label><input type="radio" name="fade" value="on" <?php if (isset($opt['fade']) && $opt['fade'] == 'on') echo 'checked="checked"' ?> > On</label> <label><input type="radio" name="fade" value="off" <?php if (!isset($opt['fade']) || $opt['fade'] != 'on') echo 'checked="checked"' ?> > Off</label></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label>Always On ( if set to on will always show the hilighted areas)</label></th>
			<td><label><input type="radio" name="always-on" value="on" <?php if (isset($opt['always-on']) && $opt['always-on'] == 'on') echo 'checked="checked"' ?>> On</label> <label><input type="radio" name="always-on" value="off" <?php if (!isset($opt['always-on']) || $opt['always-on'] != 'on') echo 'checked="checked"' ?>> Off</label></td>
		</tr>
	</table>
	<p class="submit"><input type="submit" class="button-primary" name="save" value="Save Changes"></p>
	</form>
</div>

<div class="image_map_preview_wrap">
<h3>Map Preview:</h3>
<div class="image_map_preview">
	<div class="area-border"></div>
	<div class="area-shadow"></div>
	<div class="area"></div>
	<div class="tooltip">Tooltip</div>
</div>
</div>

</div>
<?php
}

function image_map_shortcode($atts) {
	
	$maps = image_map_load_maps();
	$maps_list = image_map_maps_list();
	$id = ( isset($atts['id']) ) ? $atts['id'] : current(array_keys($maps_list));
	$map = $maps[$id];
	$links = get_option('image_map_links');
	
	$html = '<img src="'. plugins_url( $id . '.png' , __FILE__ ) .'" usemap="#'.$id.'" class="map" style="border-style:none; margin:0" />
        <map id="'.$id.'" name="'.$id.'">';

	foreach($map as $link=>$area) {
		$atts_link_safe = str_replace(' ', '_', strtolower($link));
		$link_safe = $id . '_' . $atts_link_safe;
		if ( !empty($links[$link_safe]) || (!empty($atts[$atts_link_safe])) ) {
			$real_link = ( isset($atts[$atts_link_safe]) ) ? $atts[$atts_link_safe] : $links[$link_safe];
			$html .= str_replace('{link}', $real_link, $area);
		}
	}
	
	$html .= '</map>';
	return $html;
}
add_shortcode('image_map', 'image_map_shortcode');

function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}
?>