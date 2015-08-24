<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title>
  
 <?php wp_title('|',true,'left'); ?>

</title>
<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		
	
<?php wp_head(); ?> 

</head>
<body <?php body_class(); ?>>

<div id="wrapper">
<div id="container">


<div id="header">
<div class="top">
<div id="siteinfo">
<h1><a href="<?php echo esc_url(home_url()); ?>/"><?php bloginfo('name'); ?></a></h1></div>
<div class="site-description"><?php bloginfo( 'description' ); ?></div>
</div>
		<div class="cssmenu">
		<?php wp_nav_menu( array( 'theme_location' => 'header-left', 'depth' => 1 ) ); ?></div>
		<div class="cssmenu">
		<?php wp_nav_menu( array( 'theme_location' => 'header-center','depth' => 1  ) ); ?></div>
			<div class="cssmenu">
		<?php wp_nav_menu( array( 'theme_location' => 'header-right','depth' => 1  ) ); ?></div>
	
	<div class="clear"></div>
</div>
<hr>	
	<div id="main">
