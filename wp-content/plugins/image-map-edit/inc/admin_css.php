<style type="text/css">
.image_map_preview_wrap {
position: fixed;
top: 50px;
right: 20px;
}
.image_map_preview {
position: relative;
width: 250px;
height: 180px;
border: 1px solid #999;
background: url(<?php echo plugins_url( '/admin_map.png' , __FILE__ ); ?>) center center no-repeat;
}
.area-border, .area-shadow, .area {
position: absolute;
width: 100px;
height: 80px;
left: 75px;
top: 50px;
background: transparent;
z-index: 1;
}
.area-border {
z-index: 2;
top: <?php echo (50 - $opt['area-border-width']); ?>px;
left: <?php echo (75 - $opt['area-border-width']); ?>px;
border: <?php echo $opt['area-border-width']; ?>px solid <?php echo $opt['area-border-color']; ?>;
opacity: <?php echo $opt['area-border-opacity']; ?>;
}
.area-shadow {
<?php
$color = hex2rgb($opt['shadow-color']);
$color_rgb = $color[0] . ', ' . $color[1] . ', ' . $color[2];
?>
box-shadow: <?php echo $opt['shadow-x'] . 'px ' . $opt['shadow-y'] . 'px ' . $opt['shadow-radius'] . 'px rgba(' . $color_rgb . ', ' . $opt['shadow-opacity'] . ')'; ?>;
}
.area {
background: <?php echo $opt['area-color']; ?>;
opacity: <?php echo $opt['area-opacity']; ?>;
}

.tooltip {
position: absolute;
z-index: 3;
top: 40px;
right: 40px;
padding:<?php echo $opt['tooltip-padding-vertical']; ?>px <?php echo $opt['tooltip-padding-horizontal']; ?>px;
border: <?php echo $opt['tooltip-border-width']; ?>px solid <?php echo $opt['tooltip-border-color']; ?>;
color:<?php echo $opt['tooltip-text-color']; ?>;
background-color:<?php echo $opt['tooltip-color']; ?>;
}
<?php
if (isset($opt['no-area']))	echo '.area { display: none; }';
if (isset($opt['no-border']))	echo '.area-border { display: none; }';
if (isset($opt['no-shadow']))	echo '.area-shadow { display: none; }';
?>
</style>