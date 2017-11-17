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
 * STAFF MEMBERS HOME PAGE
 ***************************************************************/
function staff_home() {
    ob_start();
    get_template_part('includes/staff_members_loop');
    return ob_get_clean();
} 
add_shortcode( 'staff_home', 'staff_home' );

function staff_carousel() {
    ob_start();
    get_template_part('includes/staff_members_carousel');
    return ob_get_clean();
} 
add_shortcode( 'staff_carousel', 'staff_carousel' );

/***************************************************************
 * Scripts
 ***************************************************************/

function theme_scripts(){
	wp_register_script('jquery-cdn', 'http://code.jquery.com/jquery-1.11.0.min.js', array('jquery'), null, true);
	
	wp_register_script('jquery-migrate', 'http://code.jquery.com/jquery-1.11.0.min.js', array('jquery'), null, true);
	
	wp_register_script('slick-js', get_stylesheet_directory_uri() . '/js/slick/slick.min.js', array('jquery'), null, true);
	
	wp_register_script('main-js', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery'), null, true);
	
	wp_register_script('fontawesome', 'https://use.fontawesome.com/6ccd600e51.js', array('jquery'), null, true);

	wp_enqueue_script('jquery-cdn');
	wp_enqueue_script('jquery-migrate');
	wp_enqueue_script('slick-js');
	wp_enqueue_script('main-js');
	wp_enqueue_script('fontawesome');
}

function extra_styles() {
	wp_enqueue_style( 'slick-style', get_stylesheet_directory_uri() . '/slick/slick.css' );
}

add_action('init', 'theme_scripts');
add_action('wp_enqueue_scripts', 'extra_styles');

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