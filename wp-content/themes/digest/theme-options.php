<?php

if ( ! function_exists( 'dig_options_admin_menu' ) ) :
  function dig_options_admin_menu() 
  {	    
	$dig_theme_page = add_theme_page(__("Digest Options", 'digest'), __("Digest Options", 'digest'), 
	  'edit_theme_options', 'dig_general_options_page', 'dig_general_options_page');	
  };
  endif; 
  
  add_action('admin_menu', 'dig_options_admin_menu');
  
  $dig_options = get_option( 'dig_options' );	
$dig_options = array(
	'dig_favicon_url' => '',
);
  
  add_action('wp_head', 'dig_head');
    if ( ! function_exists( 'dig_head' ) ) :
  function dig_head()
  {  
    if (!is_admin())
	{
	  global $dig_favicon_url;
?>	
<link rel="shortcut icon" href="<?php echo sanitize_text_field(dig_get_option('dig_favicon_url', $dig_favicon_url)); ?>" type="image/x-icon" />
<?php	
	  $background = get_theme_mod('background_image', false);
	  $bgcolor = get_theme_mod('background_color', false);
?>

<?php	  
	};
  };
    endif;
	 function dig_options_update() 
   {
     global $_POST, $dig_favicon_url;
		
	 if ($_POST['dig_favicon_url'] != '')
	 {
	   update_option('dig_favicon_url', $_POST['dig_favicon_url']);
	 } else 
	 {
	   update_option('dig_favicon_url', $dig_favicon_url);	  
	 };
		
		  };
		  
 function dig_options_validate ( $dig_options) {  
    $output = array();  
    foreach( $dig_options as $key => $value ) {  
        if( isset( $dig_options[$key] ) ) {  
            $output[$key] = strip_tags( stripslashes( $dig_options[ $key ] ) );        
        }          
    }  
    return apply_filters( 'dig_options_validate', $output, $dig_options );    
}  

  

	
function dig_general_options_input() {  
register_setting('dig_general_options_page','dig_general_options_page','dig_options_validate'); 
register_setting( 'dig_general_options_page', 'dig_favicon_url' ); 
}

add_action( 'admin_init', 'dig_general_options_input' );  		  
 
   
    if ( ! function_exists( 'dig_general_options_page' ) ) :
  function dig_general_options_page()
  {
    global  $_POST, $dig_favicon_url; 
	
 if ( isset($_POST['update_options']) && $_POST['update_options'] == 'true' )
?>	
	    <div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>
      		<h2><?php _e('Digest General Options', 'digest'); ?></h2>

        <form method="post" action="options.php">
		<?php 
 wp_nonce_field('update-options'); ?>

			
            <table class="form-table">

 <tr valign="top">
                    <th scope="row"><label for="dig_favicon_url"><?php _e('Favicon:', 'digest'); ?></label></th>
                    <td><input type="text" name="dig_favicon_url" size="95" 
					  value="<?php echo sanitize_text_field(dig_get_option('dig_favicon_url', $dig_favicon_url)); ?>"/>
					<br/>
					<span class="description"> 
					<?php printf(__('<a href="%s" target="_blank">Upload your favicon</a> using WordPress Media Library and insert its URL here', 
					  'digest'), esc_url(home_url().'/wp-admin/media-new.php')); ?>
					</span><br/><br/>
					<img src="<?php echo sanitize_text_field(dig_get_option('dig_favicon_url', $dig_favicon_url)); ?>" alt=""/>
					</td>
                </tr>	  		
			    										
					
            </table>
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="dig_favicon_url" />
     			<p><?php submit_button( $text=null, $type='submit', $name = 'submit', $wrap = true, $other_attributes = null) ?></p>
        </form>
		
    </div>
	<?php

if ( !empty($_POST) && check_admin_referer( 'update-options') ) {
}

  };
   endif; 
