<?php 

/* STYLESHEET ACTIVATION */
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );}
/* STYLESHEET ACTIVATION */

/* CUSTOM STYLES */
function wpb_mce_buttons_2($buttons) {
array_unshift($buttons, 'styleselect');
return $buttons;}add_filter('mce_buttons_2', 'wpb_mce_buttons_2');

function my_mce_before_init_insert_formats( $init_array ) { 
$style_formats = array( 
array( 
'title' => 'Blue Button', 
'block' => 'span', 
'classes' => 'smallbluecta-button small-button',
'wrapper' => true,
),
); 
$init_array['style_formats'] = json_encode( $style_formats ); 
return $init_array; 
}
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );

function my_theme_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}
add_action( 'admin_init', 'my_theme_add_editor_styles' );
/* CUSTOM STYLES */

/* TOP MENU */
function register_my_menu() {
  register_nav_menu('new-menu',__( 'Main Top Menu' ));
}
add_action( 'init', 'register_my_menu' );
/* TOP MENU */

/* ACF OPTIONS PANEL */
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();
	
	acf_add_options_sub_page('Header');
	acf_add_options_sub_page('Footer');
}
/* ACF OPTIONS PANEL */

/***************************************************************
 * FAQ Accordion
 ***************************************************************/
function accordion_toggle() {
    ob_start();
    get_template_part('includes/accordion_toggle');
    return ob_get_clean();
} 
add_shortcode( 'accordion_toggle', 'accordion_toggle' );

function rmt_toggle() {
    ob_start();
    get_template_part('includes/rmt_toggle');
    return ob_get_clean();
} 
add_shortcode( 'rmt_toggle', 'rmt_toggle' );

/***************************************************************
 * Scripts
 ***************************************************************/

function theme_scripts(){
	
	// Scripts
	wp_register_script('jquery-cdn', 'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', array('jquery'), null, true);
	wp_register_script('main-js', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery'), null, true);
	wp_register_script('fontawesome', 'https://use.fontawesome.com/6ccd600e51.js', array('jquery'), null, true);

	wp_enqueue_script('jquery-cdn');
	wp_enqueue_script('main-js');
	wp_enqueue_script('fontawesome');

}
add_action('wp_enqueue_scripts', 'theme_scripts', 100);

/***************************************************************
 * Remove Comments
 ***************************************************************/

function remove_widgets() {
	unregister_widget('WP_Widget_Recent_Comments');
}

function remove_menu_items(){
 	remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'remove_menu_items' );
add_action( 'widgets_init', 'remove_widgets' );