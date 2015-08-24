<?php
/*
 WARNING: This is a core Generate file. DO NOT edit
 this file under any circumstances. Please do all modifications
 in the form of a child theme.
 */

/**
 * Creates the options page.
 *
 * This file is a core Generate file and should not be edited.
 *
 * @package  GeneratePress
 * @author   Thomas Usborne
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.generatepress.com
 */

// create custom plugin settings menu
add_action('admin_menu', 'generate_create_menu');
function generate_create_menu() 
{
	
	$generate_page = add_theme_page( __('GeneratePress','generate'), __('GeneratePress','generate'), 'edit_theme_options', 'generate-options', 'generate_settings_page' );
	
	add_action( "admin_print_scripts-$generate_page", 'generate_options_scripts' );
	add_action( "admin_print_styles-$generate_page", 'generate_options_styles' );
}

function generate_options_scripts() 
{
	// Something will go here one day...
}

function generate_options_styles() 
{
     wp_enqueue_style( 
        'generate-options', 
        get_template_directory_uri() . '/inc/css/style.css'
    );
	
	wp_enqueue_style( 
		'generate-style-grid', 
		get_template_directory_uri() . '/css/unsemantic-grid.css', 
		false, 
		GENERATE_VERSION, 
		'all' 
	);
}

function generate_settings_page() 
{
	?>
	<div class="wrap">
		<div class="metabox-holder">
			<div class="postbox-container" style="float: none;max-width:1120px;">
				<div class="grid-container grid-parent">
						
					<div class="form-metabox grid-70" style="padding-left:0;">
						<form method="post" action="options.php">
							<?php settings_fields( 'generate-settings-group' ); ?>
							<?php do_settings_sections( 'generate-settings-group' ); ?>
							<div class="customize-button hide-on-desktop">
								<a id="generate_customize_button" class="button button-primary" href="<?php echo admin_url('customize.php'); ?>"><?php _e('Customize','generate');?></a>  
							</div>
							<div class="postbox generate-metabox" id="gen-1">
								<h3 class="hndle"><?php _e('GeneratePress','generate');?></h3>
								<div class="inside">
									<p>
										<strong style="display:inline-block;width:60px;"><?php _e('Version','generate');?>:</strong> <?php echo GENERATE_VERSION; ?><br />
										<strong style="display:inline-block;width:60px;"><?php _e('Author','generate');?>:</strong> <a href="<?php echo esc_url('http://edge22.com');?>" target="_blank">Tom Usborne</a><br />
										<strong style="display:inline-block;width:60px;"><?php _e('Website','generate');?>:</strong> <a href="<?php echo esc_url('http://generatepress.com');?>" target="_blank">GeneratePress</a>
									</p>
										
												
									<p>
										<a id="generate_customize_button" class="button button-primary" href="<?php echo admin_url('customize.php'); ?>"><?php _e('Customize','generate');?></a>  
										<?php if ( generate_addons_available() ) : ?>
											<a id="generate_addon_button" class="button button-primary" href="<?php echo esc_url('http://generatepress.com/add-ons');?>" target="_blank"><?php _e('Add-ons','generate');?></a> 
										<?php endif; ?>
										<a title="<?php _e('Please help support ongoing development of the GeneratePress by buying me a coffee :)','generate');?>" class="button button-secondary" target="_blank" href="<?php echo esc_url('https://generatepress.com/ongoing-development');?>"><?php _e('Buy me a coffee :)','generate');?></a>
									</p>
								</div>
							</div>

							<?php do_action('generate_inside_options_form'); ?>
								
							<div class="postbox generate-metabox" id="gen-license-keys">
								<h3 class="hndle"><?php _e('Add-on Updates','generate');?></h3>
								<div class="inside">
									
									<?php
									if ( generate_no_addons() == true ) :
										echo '<div class="no-addons">' . __('No add-ons to keep up to date!','generate') . '</div>';
									endif;
										
									do_action('generate_license_key_items'); 
									?>

								</div>
							</div>

						</form>
										
						<?php do_action('generate_options_items'); ?>
							
						<div class="postbox generate-metabox" id="gen-delete">
							<h3 class="hndle"><?php _e('Delete Customizer Settings','generate');?></h3>
							<div class="inside">
												
								<p><?php _e( '<strong>Warning:</strong> Deleting your <a href="' . admin_url('customize.php') . '">Customizer</a> settings can not be undone.','generate' ); ?></p>
								<p><?php _e( 'Consider using our Import/Export add-on to export your settings before deleting them.','generate');?></p>
								<form method="post">
									<p><input type="hidden" name="generate_reset_customizer" value="generate_reset_customizer_settings" /></p>
									<p>
										<?php 
										$warning = 'return confirm("' . __( 'Warning: This will delete your settings.','generate' ) . '")';
										wp_nonce_field( 'generate_reset_customizer_nonce', 'generate_reset_customizer_nonce' );
										submit_button( __( 'Delete Default Customizer Settings', 'generate' ), 'button', 'submit', false, array( 'onclick' => $warning ) ); 
										?>
									</p>
										
								</form>
								<?php do_action('generate_delete_settings_form');?>
							</div>
						</div>
					</div>
						
					<div class="generate-right-sidebar grid-30" style="padding-right:0;">
						<div class="customize-button hide-on-mobile">
							<a id="generate_customize_button" class="button button-primary" href="<?php echo admin_url('customize.php'); ?>"><?php _e('Customize','generate');?></a>  
						</div>
						<div class="postbox generate-metabox addon-metabox" id="gen-2">
							<h3 class="hndle"><?php _e('Add-ons','generate');?></h3>
							<div class="inside">
								<p>
									<?php 
									
									$addons = array(
										'0' => array(
												'name' => __('Colors','generate'),
												'id' => 'generate_colors_setup',
												'package' => 'generate_package_colors',
												'url' => esc_url('http://www.generatepress.com/downloads/generate-colors/'),
												'img' => get_template_directory_uri() . '/inc/add-ons/images/colors.png'
							
										),
										'10' => array(
												'name' => __('Sections','generate'),
												'id' => 'generate_sections_init',
												'package' => 'generate_package_sections',
												'url' => esc_url('http://www.generatepress.com/downloads/generate-sections/'),
												'img' => get_template_directory_uri() . '/inc/add-ons/images/sections.png'
							
										),
										'20' => array(
												'name' => __('Typography','generate'),
												'id' => 'generate_fonts_setup',
												'package' => 'generate_package_typography',
												'url' => esc_url('http://www.generatepress.com/downloads/generate-typography/'),
												'img' => get_template_directory_uri() . '/inc/add-ons/images/typography.png'
										 ),
										'30' => array(
												'name' => __('Menu Plus','generate'),
												'id' => 'generate_menu_plus_setup',
												'package' => 'generate_package_menu_plus',
												'url' => esc_url('http://www.generatepress.com/downloads/generate-menu-plus/'),
												'img' => get_template_directory_uri() . '/inc/add-ons/images/menu-plus.png'
										 ),
										'40' => array(
												'name' => __('Page Header','generate'),
												'id' => 'generate_page_header',
												'package' => 'generate_package_page_header',
												'url' => esc_url('http://www.generatepress.com/downloads/generate-page-header/'),
												'img' => get_template_directory_uri() . '/inc/add-ons/images/page-header.png'
										),
										'50' => array(
												'name' => __('Import / Export','generate'),
												'id' => 'generate_insert_import_export',
												'package' => 'generate_package_import_export',
												'url' => esc_url('http://www.generatepress.com/downloads/generate-import-export/'),
												'img' => get_template_directory_uri() . '/inc/add-ons/images/importexport.png'
										),
										'60' => array(
												'name' => __('Copyright','generate'),
												'id' => 'generate_copyright_option',
												'package' => 'generate_package_copyright',
												'url' => esc_url('http://www.generatepress.com/downloads/generate-copyright/'),
												'img' => get_template_directory_uri() . '/inc/add-ons/images/copyright.png'
										),
										'70' => array(
												'name' => __('Disable Elements','generate'),
												'id' => 'generate_disable_elements',
												'package' => 'generate_package_disable_elements',
												'url' => esc_url('http://www.generatepress.com/downloads/generate-disable-elements/'),
												'img' => get_template_directory_uri() . '/inc/add-ons/images/disable-items.png'
										),
										'80' => array(
												'name' => __('Blog','generate'),
												'id' => 'generate_blog_get_defaults',
												'package' => 'generate_package_blog',
												'url' => esc_url('http://www.generatepress.com/downloads/generate-blog/'),
												'img' => get_template_directory_uri() . '/inc/add-ons/images/blog.png'
										),
										'90' => array(
												'name' => __('Hooks','generate'),
												'id' => 'generate_hooks_setup',
												'package' => 'generate_package_hooks',
												'url' => esc_url('http://www.generatepress.com/downloads/generate-hooks/'),
												'img' => get_template_directory_uri() . '/inc/add-ons/images/hooks.png'
										),
										'100' => array(
												'name' => __('Spacing','generate'),
												'id' => 'generate_spacing_setup',
												'package' => 'generate_package_spacing',
												'url' => esc_url('http://www.generatepress.com/downloads/generate-spacing/'),
												'img' => get_template_directory_uri() . '/inc/add-ons/images/spacing.png'
										),
										'110' => array(
												'name' => __('Backgrounds','generate'),
												'id' => 'generate_backgrounds_setup',
												'package' => 'generate_package_backgrounds',
												'url' => esc_url('http://www.generatepress.com/downloads/generate-backgrounds/'),
												'img' => get_template_directory_uri() . '/inc/add-ons/images/backgrounds.png'
										),
										'120' => array(
												'name' => __('Secondary Nav','generate'),
												'id' => 'generate_secondary_nav_setup',
												'package' => 'generate_package_secondary_nav',
												'url' => esc_url('http://www.generatepress.com/downloads/generate-secondary-nav/'),
												'img' => get_template_directory_uri() . '/inc/add-ons/images/secondarynav.png'
										)
									);
										
									foreach ( $addons as $addon ) {
										// If GP Premium is installed
										if ( defined( 'GP_PREMIUM_VERSION' ) ) {
											if ( get_option( $addon['package'] ) !== 'activated' ) :
												echo '<span class="addon-inactive"><a title="' . $addon['name'] . ': ' . __('Not activated.','generate') . '" href="' . $addon['url'] . '" target="_blank"><img src="' . $addon['img'] . '" alt="' . $addon['name'] . '" /></a></span>';
											else :
												echo '<span class="addon-active"><a title="' . $addon['name'] . ': ' . __('Activated.','generate') . '" href="' . $addon['url'] . '" target="_blank"><img src="' . $addon['img'] . '" alt="' . $addon['name'] . '" /></a></span>';
											endif;
										// If GP Premium isn't installed
										} else {
											if ( ! function_exists( $addon['id'] ) ) :
												echo '<span class="addon-inactive"><a title="' . $addon['name'] . ': ' . __('Not activated.','generate') . '" href="' . $addon['url'] . '" target="_blank"><img src="' . $addon['img'] . '" alt="' . $addon['name'] . '" /></a></span>';
											else :
												echo '<span class="addon-active"><a title="' . $addon['name'] . ': ' . __('Activated.','generate') . '" href="' . $addon['url'] . '" target="_blank"><img src="' . $addon['img'] . '" alt="' . $addon['name'] . '" /></a></span>';
											endif;	
										}
									}
									?>		
								</p>
							</div>
						</div>
						<?php do_action( 'generate_admin_right_panel' ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php }

/**
 * Reset customizer settings
 */
add_action( 'admin_init', 'generate_reset_customizer_settings' );
function generate_reset_customizer_settings() {

	if( empty( $_POST['generate_reset_customizer'] ) || 'generate_reset_customizer_settings' !== $_POST['generate_reset_customizer'] )
		return;

	if( ! wp_verify_nonce( $_POST['generate_reset_customizer_nonce'], 'generate_reset_customizer_nonce' ) )
		return;

	if( ! current_user_can( 'manage_options' ) )
		return;

	delete_option('generate_settings');
	
	wp_safe_redirect( admin_url( 'themes.php?page=generate-options&status=reset' ) ); exit;

}

if ( ! function_exists( 'generate_admin_errors' ) ) :
/**
 * Add our admin notices
 */
add_action( 'admin_notices', 'generate_admin_errors' );
function generate_admin_errors() 
{
	$screen = get_current_screen();
	if ( 'appearance_page_generate-options' !== $screen->base )
		return;
		
	if ( isset( $_GET['settings-updated'] ) && 'true' == $_GET['settings-updated'] ) {
		 add_settings_error( 'generate-notices', 'true', __( 'Settings saved.', 'generate' ), 'updated' );
	}
	
	if ( isset( $_GET['status'] ) && 'imported' == $_GET['status'] ) {
		 add_settings_error( 'generate-notices', 'imported', __( 'Import successful.', 'generate' ), 'updated' );
	}
	
	if ( isset( $_GET['status'] ) && 'reset' == $_GET['status'] ) {
		 add_settings_error( 'generate-notices', 'reset', __( 'Settings removed.', 'generate' ), 'updated' );
	}

	settings_errors( 'generate-notices' );
}
endif;