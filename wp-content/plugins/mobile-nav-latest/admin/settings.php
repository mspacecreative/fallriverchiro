<?php
/**
 * Mobile.Nav Settings page in WP admin
 */




/**
 *
 * Default settings
 *
 */
$sdrn_setup = array(
    'enabled' => 1,
    'menu' => '',
    'custom_for_logged_in' => 'no',
    'logged_in_menu' => '',
    'menu_symbol_pos' => 'left',
    'bar_title' => 'MENU',
    'nesting_icon' => '',
    'nesting_icon_open' => '',
    'expand_sub_with_parent' => 'no',
    'from_width' => 961,
    'position' => 'top',
    'how_wide' => '80',
    'swipe_actions' => 'yes',
    'hide' => array(),
    'zooming' => 'no',
    'animation' => 'jquery',
    'searchbar' => 'no',
    'searchbar_label' => 'Search',
    'bar_bgd' => '#0D0D0D',
    'bar_color' => '#F2F2F2',
    'menu_bgd' => '#2E2E2E',
    'menu_color' => '#CFCFCF',
    'menu_color_hover' => '#606060',
    'menu_border_top' => '#474747',
    'menu_border_bottom' => '#131212',
    'menu_border_bottom_show' => 'yes',
    'icons_for_items' => array(),
    'logmenu_icons_for_items' => array(),
    'searchbar_border_color' => '#696969',
    'searchbar_background_color' => '#565656'
);




if(!get_option('sdrn_options')) {
    /**
     *
     * Save the default settings if not present
     *
     */
    add_option('sdrn_options', $sdrn_setup);
} else {
    /**
     * Updating options for previous releases
     */
    $sdrn_setup = get_option('sdrn_options');
    if(!isset($sdrn_setup['swipe_actions'])) $sdrn_setup['swipe_actions'] = 'yes';
    if(!isset($sdrn_setup['expand_sub_with_parent'])) $sdrn_setup['expand_sub_with_parent'] = 'no';
    if(!isset($sdrn_setup['animation'])) $sdrn_setup['animation'] = 'jquery';
    if(!isset($sdrn_setup['searchbar'])) $sdrn_setup['searchbar'] = 'no';
    if(!isset($sdrn_setup['searchbar_label'])) $sdrn_setup['searchbar_label'] = 'Search';
    if(!isset($sdrn_setup['custom_for_logged_in'])) $sdrn_setup['custom_for_logged_in'] = 'no';
    if(!isset($sdrn_setup['logged_in_menu'])) $sdrn_setup['logged_in_menu'] = 'no';
    if(!isset($sdrn_setup['icons_for_items'])) $sdrn_setup['icons_for_items'] = array();
    if(!isset($sdrn_setup['logmenu_icons_for_items'])) $sdrn_setup['logmenu_icons_for_items'] = array();
    if(!isset($sdrn_setup['searchbar_border_color'])) $sdrn_setup['searchbar_border_color'] = '#696969';
    if(!isset($sdrn_setup['searchbar_background_color'])) $sdrn_setup['searchbar_background_color'] = '#565656';

    update_option('sdrn_options', $sdrn_setup);
}








/**
 *
 * Add settings page menu item
 *
 */
if ( is_admin() ){
    /**
     * action name
     * function that will create the menu page link / options page
     */
    add_action( 'admin_menu', 'sdrn_admin_menu' );
}



/**
 *
 * Add plugin settings page
 *
 */
function sdrn_admin_menu(){
    /**
     * menu title
     * page title
     * who can acces the settings  - user that can ...
     * the settings page identifier for the url
     * function that will generate the form with th esettings
     */
    add_options_page(__('Mobile.Nav','sdrn'),__('Mobile.Nav','sdrn'),'manage_options','sdrn_settings','sdrn_settings');
}



function sdrn_add_admin_scripts() {
    if ( 'settings_page_sdrn_settings' == get_current_screen()->id ) {
        if(function_exists( 'wp_enqueue_media' )){
            wp_enqueue_media();
        }else{
            wp_enqueue_style('thickbox');
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
        }
    }
}
add_action('admin_enqueue_scripts', 'sdrn_add_admin_scripts');








/**
 *
 * Create the tabs for the settings page
 * @param  string $current default  tab
 * @return HTML          The tab switcher
 *
 */
function sdrn_settings_tabs( $current = 'general' ) {
    $tabs = array( 'general' => __('General','sdrn'), 'appearance' => __('Appearance','sdrn'));
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=sdrn_settings&tab=$tab'>$name</a>";
    }
    echo '</h2>';
}







/**
 *
 * The settings wrappers
 * one for 'general' and 'emails' tabs
 * one for subscribers list
 *
 */
function sdrn_settings() {
    ?>
    <div class="wrap">
        <br>
        <br>
        <img src="<?php echo plugins_url( 'mobile-nav-wp-setting-logo.png' , __FILE__ ) ?>"/>
        <br>
        <br>
        <?php ( isset($_GET['tab']) )? sdrn_settings_tabs($_GET['tab']) : sdrn_settings_tabs('general'); ?>
        <form method="post" action="options.php" enctype="multipart/form-data">
            <?php
            settings_fields('sdrn_options');
            do_settings_sections('sdrn_plugin');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}






/**
 *
 * Initialize the settings
 *
 */
if ( is_admin() ) {
    /**
     * action name
     * function that will do all the initialization
     */
    add_action('admin_init', 'sdrn_admin_init');
}






/**
 *
 * Settings sections and fields setup
 *
 */
function sdrn_admin_init(){
    register_setting( 'sdrn_options', 'sdrn_options', 'sdrn_options_validate' );
    //
    if(!isset($_GET['tab']) || $_GET['tab'] == 'general') {
        add_settings_section('sdrn_general_settings', '<br>'.__('General settings','sdrn'), 'sdrn_general_settings_section', 'sdrn_plugin');
        //
        add_settings_field('sdrn_enabled', __('Enable mobile navigation','sdrn'), 'sdrn_general_settings_enabled', 'sdrn_plugin', 'sdrn_general_settings');
        //
        add_settings_field('sdrn_menu', __('Choose the wordpress menu','sdrn'), 'sdrn_general_settings_menu', 'sdrn_plugin', 'sdrn_general_settings');
        //
        add_settings_field('custom_for_logged_in', __('Custom menu for logged in users?','sdrn'), 'sdrn_general_settings_custom_for_logged_in', 'sdrn_plugin', 'sdrn_general_settings');
        //
        add_settings_field('logged_in_menu', __('Choose the wordpress menu for logged in users','sdrn'), 'sdrn_general_settings_logged_in_menu', 'sdrn_plugin', 'sdrn_general_settings');
        //
        add_settings_field('sdrn_menu_symbol_pos', __('Menu symbol position (on the top menu bar)','sdrn'), 'sdrn_general_settings_menu_symbol_pos', 'sdrn_plugin', 'sdrn_general_settings');
        //
        add_settings_field('sdrn_bar_title', __('Display text for the top menu bar','sdrn'), 'sdrn_general_settings_bar_title', 'sdrn_plugin', 'sdrn_general_settings');
        //
        add_settings_field('sdrn_bar_logo', __('Choose optional logo image for the top menu bar','sdrn'), 'sdrn_general_settings_bar_logo', 'sdrn_plugin', 'sdrn_general_settings');
        //
        add_settings_field('sdrn_nesting_icon', __('Optional custom submenus icon.<br>Uses icons from <a href="http://fortawesome.github.io/Font-Awesome/" target="_blank">font awesome</a>.<br/>Pick Your icon <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a> and input the icon sumbol like <strong>fa-plus</strong>.<br/>Leave empty for a default icon','sdrn'), 'sdrn_general_settings_nesting_icon', 'sdrn_plugin', 'sdrn_general_settings');
        //
        add_settings_field('sdrn_nesting_icon_opened', __('Optional custom font awesome icon for opened submenu','sdrn'), 'sdrn_general_settings_nesting_icon_open', 'sdrn_plugin', 'sdrn_general_settings');
        //
        add_settings_field('sdrn_expand_sub_with_parent', __('Expand submenu by clicking parent item','sdrn'), 'sdrn_general_settings_expand_sub_with_parent', 'sdrn_plugin', 'sdrn_general_settings');
        //
        add_settings_field('sdrn_from_width', __('Display menu from width (below in pixels)','sdrn'), 'sdrn_general_settings_from_width', 'sdrn_plugin', 'sdrn_general_settings');
        //
        add_settings_field('sdrn_position', __('Menu position','sdrn'), 'sdrn_general_settings_position', 'sdrn_plugin', 'sdrn_general_settings');
        //
        add_settings_field('sdrn_how_wide', __('Width of the open menu (only for LEFT position - % of total page width)','sdrn'), 'sdrn_general_settings_how_wide', 'sdrn_plugin', 'sdrn_general_settings');
        //
        add_settings_field('swipe_actions', __('Enable the "swipe to open/close" for touch screens?','sdrn'), 'sdrn_general_settings_swipe_actions', 'sdrn_plugin', 'sdrn_general_settings');
        //
        add_settings_field('sdrn_hide', __('Hide other navigation elements. CSS selectors (IDs or classes, coma separated)','sdrn').'<br>'.__('CSS sellectors (IDs and classes coma separated)','sdrn'), 'sdrn_general_settings_hide', 'sdrn_plugin', 'sdrn_general_settings');
        //
        add_settings_field('sdrn_zooming', __('Allow zooming on mobile devices?','sdrn'), 'sdrn_general_settings_zooming', 'sdrn_plugin', 'sdrn_general_settings');
        //
        add_settings_field('sdrn_animation', __('Animate menu with','sdrn'), 'sdrn_general_settings_animation', 'sdrn_plugin', 'sdrn_general_settings');   
        //
        add_settings_field('sdrn_searchbar', __('Add search bar to the menu?','sdrn'), 'sdrn_general_settings_searchbar', 'sdrn_plugin', 'sdrn_general_settings');   
        //
        add_settings_field('sdrn_searchbar_label', __('Search bar label','sdrn'), 'sdrn_general_settings_searchbar_label', 'sdrn_plugin', 'sdrn_general_settings');   
    }
    //
    if(isset($_GET['tab']) && $_GET['tab'] == 'appearance') {
        add_settings_section('sdrn_appearance_settings', '<br>'.__('Menu appearance','sdrn'), 'sdrn_appearance_settings_section', 'sdrn_plugin');
        //
        add_settings_field('sdrn_bar_bgd', __('Menu top bar background color','sdrn'), 'sdrn_appearance_settings_bar_bgd', 'sdrn_plugin', 'sdrn_appearance_settings');
        //
        add_settings_field('sdrn_bar_color', __('Menu top bar text color','sdrn'), 'sdrn_appearance_settings_bar_color', 'sdrn_plugin', 'sdrn_appearance_settings');
        //
        add_settings_field('sdrn_menu_bgd', __('Menu background color','sdrn'), 'sdrn_appearance_settings_menu_bgd', 'sdrn_plugin', 'sdrn_appearance_settings');
        //
        add_settings_field('sdrn_menu_color', __('Menu text color','sdrn'), 'sdrn_appearance_settings_menu_color', 'sdrn_plugin', 'sdrn_appearance_settings');
        //
        add_settings_field('sdrn_menu_color_hover', __('Menu text color on hover','sdrn'), 'sdrn_appearance_settings_menu_color_hover', 'sdrn_plugin', 'sdrn_appearance_settings');
        //
        add_settings_field('sdrn_menu_border_top', __('Menu borders color (top & left)','sdrn'), 'sdrn_appearance_settings_menu_border_top', 'sdrn_plugin', 'sdrn_appearance_settings');
        //
        add_settings_field('sdrn_menu_border_bottom', __('Menu borders color (bottom)','sdrn'), 'sdrn_appearance_settings_menu_border_bottom', 'sdrn_plugin', 'sdrn_appearance_settings');
        //
        add_settings_field('sdrn_menu_border_bottom_show', __('Enable/disable bottom border on menu list items','sdrn'), 'sdrn_appearance_settings_menu_border_bottom_show', 'sdrn_plugin', 'sdrn_appearance_settings');
        //
        add_settings_field('sdrn_menu_searchbar_border_color', __('Search bar border color','sdrn'), 'sdrn_appearance_settings_searchbar_border_color', 'sdrn_plugin', 'sdrn_appearance_settings');
        //
        add_settings_field('sdrn_menu_searchbar_background_color', __('Search bar background color','sdrn'), 'sdrn_appearance_settings_searchbar_background_color', 'sdrn_plugin', 'sdrn_appearance_settings');
        //
        add_settings_section('sdrn_appearance_settings_icons', '<br>'.__('Custom icons for menu items','sdrn'), 'sdrn_appearance_settings_section_icons', 'sdrn_plugin');
        //
        add_settings_field('sdrn_menu_icons_for_links', __('Apply icons to the menu','sdrn'), 'sdrn_appearance_settings_menu_icons', 'sdrn_plugin', 'sdrn_appearance_settings_icons');
    }
}


function sdrn_general_settings_section() {

}


function sdrn_general_settings_enabled() {
    $options = get_option('sdrn_options');
    ?>
    <label for="sdrn_enabled">
        <input name="sdrn_options[enabled]" type="checkbox" id="sdrn_enabled" value="1" <?php if($options['enabled']) echo 'checked="checked"' ?>>
        <?php ' '._e('Enabled','sdrn'); ?>
    </label>
    <?php
}


function sdrn_general_settings_menu() {
    $options = get_option('sdrn_options');
    $menus = get_terms('nav_menu',array('hide_empty'=>false));
    ?>
    <select name="sdrn_options[menu]" >
        <?php foreach( $menus as $m ): ?>
            <option <?php if($m->term_id == $options['menu']) echo 'selected="selected"'; ?>  value="<?php echo $m->term_id ?>"><?php echo $m->name ?></option>
        <?php endforeach; ?>
    </select>
    <?php
}


function sdrn_general_settings_custom_for_logged_in() {
    $options = get_option('sdrn_options');
    ?>
    <select id="custom_for_logged_in" name="sdrn_options[custom_for_logged_in]" >
        <option <?php if($options['custom_for_logged_in'] == 'yes') echo 'selected="selected"'; ?>  value="yes">Yes</option>
        <option <?php if($options['custom_for_logged_in'] == 'no') echo 'selected="selected"'; ?>  value="no">No</option>
    </select>
    <?php
}


function sdrn_general_settings_logged_in_menu() {
    $options = get_option('sdrn_options');
    $menus = get_terms('nav_menu',array('hide_empty'=>false));
    ?>
    <select id="logged_in_menu" name="sdrn_options[logged_in_menu]" >
        <?php foreach( $menus as $m ): ?>
            <option <?php if($m->term_id == $options['logged_in_menu']) echo 'selected="selected"'; ?>  value="<?php echo $m->term_id ?>"><?php echo $m->name ?></option>
        <?php endforeach; ?>
    </select>
    <?php
}


function sdrn_general_settings_menu_symbol_pos() {
    $options = get_option('sdrn_options');
    ?>
    <select id="sdmn_menu_symbol_pos" name="sdrn_options[menu_symbol_pos]" >
        <option <?php if($options['menu_symbol_pos'] == 'left') echo 'selected="selected"'; ?>  value="left">left</option>
        <option <?php if($options['menu_symbol_pos'] == 'right') echo 'selected="selected"'; ?>  value="right">right</option>
    </select>
    <?php
}

function sdrn_general_settings_bar_title() {
    $options = get_option('sdrn_options');
    ?>
    <input id="sdrn_bar_title" name="sdrn_options[bar_title]"  size="20" type="text" value="<?php echo $options['bar_title'] ?>" />
    <?php
}

function sdrn_general_settings_bar_logo() {
    $options = get_option('sdrn_options');
    ?>
    <input type="hidden" name="sdrn_options[bar_logo]" class="sdrn_bar_logo_url" value="<?php echo $options['bar_logo'] ?>">
    <span style="position:relative">
        <img style="<?php if(!$options['bar_logo']) echo 'display:none; ' ?> width:auto; height:20px; margin-bottom:-6px; margin-right:6px;" class="sdrn_bar_logo_prev" src="<?php echo $options['bar_logo'] ?>" alt="">
    </span>
    <input id="upload_bar_logo_button" type="button" class="button" value="Choose image" />
    <span class="description"><?php if(isset($options['bar_logo'])) echo ' <a class="sdrn_disc_bar_logo" href="#" style="margin-left:10px;"> Discard the image (disable logo)</a>'; ?></span>
    <?php
}


function sdrn_general_settings_nesting_icon() {
    $options = get_option('sdrn_options');
    ?>
    <input id="sdrn_nesting_icon" name="sdrn_options[nesting_icon]"  size="20" type="text" value="<?php echo $options['nesting_icon'] ?>" />
    <?php
}

function sdrn_general_settings_nesting_icon_open() {
    $options = get_option('sdrn_options');
    ?>
    <input id="sdrn_nesting_icon_open" name="sdrn_options[nesting_icon_open]"  size="20" type="text" value="<?php echo $options['nesting_icon_open'] ?>" />
    <?php
}

function sdrn_general_settings_expand_sub_with_parent() {
    $options = get_option('sdrn_options');
    ?>
    <select id="expand_sub_with_parent" name="sdrn_options[expand_sub_with_parent]" >
        <option <?php if($options['expand_sub_with_parent'] == 'yes') echo 'selected="selected"'; ?>  value="yes">Yes</option>
        <option <?php if($options['expand_sub_with_parent'] == 'no') echo 'selected="selected"'; ?>  value="no">No</option>
    </select>
    <?php
}

function sdrn_general_settings_from_width() {
    $options = get_option('sdrn_options');
    ?>
    <input id="sdrn_from_width" name="sdrn_options[from_width]" min="280" max="2500" size="20" type="number" value="<?php echo $options['from_width'] ?>" />
    <?php
}



function sdrn_general_settings_position() {
    $options = get_option('sdrn_options');
    ?>
    <select id="sdmn_menu_pos" name="sdrn_options[position]" >
        <option <?php if($options['position'] == 'top') echo 'selected="selected"'; ?>  value="top">top</option>
        <option <?php if($options['position'] == 'left') echo 'selected="selected"'; ?>  value="left">left</option>
        <option <?php if($options['position'] == 'right') echo 'selected="selected"'; ?>  value="right">right</option>
    </select>
    <?php
}


function sdrn_general_settings_how_wide() {
    $options = get_option('sdrn_options');
    ?>
    <input id="sdrn_how_wide" name="sdrn_options[how_wide]" min="30" max="100" size="20" type="number" value="<?php echo $options['how_wide'] ?>" />
    <?php
}


function sdrn_general_settings_swipe_actions() {
    $options = get_option('sdrn_options');
    ?>
    <select id="swipe_actions" name="sdrn_options[swipe_actions]" >
        <option <?php if($options['swipe_actions'] == 'yes') echo 'selected="selected"'; ?>  value="yes">Yes</option>
        <option <?php if($options['swipe_actions'] == 'no') echo 'selected="selected"'; ?>  value="no">No</option>
    </select>
    <?php
}


function sdrn_general_settings_hide() {
    $options = get_option('sdrn_options');
    ?>
    <input id="sdrn_hide" name="sdrn_options[hide]"  size="60" type="text" value="<?php echo implode(', ',$options['hide']) ?>" />
    <br><i>Example:<br/> #main_menu, .custom_menu</i>
    <?php
}


function sdrn_general_settings_zooming() {
    $options = get_option('sdrn_options');
    ?>
    <select id="sdmn_zooming" name="sdrn_options[zooming]" >
        <option <?php if($options['zooming'] == 'yes') echo 'selected="selected"'; ?>  value="yes">Yes</option>
        <option <?php if($options['zooming'] == 'no') echo 'selected="selected"'; ?>  value="no">No</option>
    </select>
    <?php
}


function sdrn_general_settings_animation() {
    $options = get_option('sdrn_options');
    ?>
    <select id="sdmn_animation" name="sdrn_options[animation]" >
        <option <?php if($options['animation'] == 'sdrn_jquery') echo 'selected="selected"'; ?>  value="sdrn_jquery">jQuery</option>
        <option <?php if($options['animation'] == 'sdrn_css3') echo 'selected="selected"'; ?>  value="sdrn_css3">css3</option>
    </select>
    <?php
}


function sdrn_general_settings_searchbar() {
    $options = get_option('sdrn_options');
    ?>
    <select id="sdmn_searchbar" name="sdrn_options[searchbar]" >
        <option <?php if($options['searchbar'] == 'yes') echo 'selected="selected"'; ?>  value="yes">Yes</option>
        <option <?php if($options['searchbar'] == 'no') echo 'selected="selected"'; ?>  value="no">no</option>
    </select>
    <?php
}


function sdrn_general_settings_searchbar_label() {
    $options = get_option('sdrn_options');
    ?>
    <input id="sdrn_searchbar_label" name="sdrn_options[searchbar_label]" type="text" value="<?php echo $options['searchbar_label'] ?>" />
    <?php
}











function sdrn_appearance_settings_section() {

}


function sdrn_appearance_settings_bar_bgd() {
    $options = get_option('sdrn_options');
    ?>
    <input maxlength="7" size="5" type="text" name="sdrn_options[bar_bgd]" id="sdrn_bar_bgd_picker"  value="<?php echo $options['bar_bgd']; ?>" />
    <?php
}


function sdrn_appearance_settings_bar_color() {
    $options = get_option('sdrn_options');
    ?>
    <input maxlength="7" size="5" type="text" name="sdrn_options[bar_color]" id="sdrn_bar_color_picker"  value="<?php echo $options['bar_color']; ?>" />
    <?php
}


function sdrn_appearance_settings_menu_bgd() {
    $options = get_option('sdrn_options');
    ?>
    <input maxlength="7" size="5" type="text" name="sdrn_options[menu_bgd]" id="sdrn_menu_bgd_picker"  value="<?php echo $options['menu_bgd']; ?>" />
    <?php
}


function sdrn_appearance_settings_menu_color() {
    $options = get_option('sdrn_options');
    ?>
    <input maxlength="7" size="5" type="text" name="sdrn_options[menu_color]" id="sdrn_menu_color_picker"  value="<?php echo $options['menu_color']; ?>" />
    <?php
}


function sdrn_appearance_settings_menu_color_hover() {
    $options = get_option('sdrn_options');
    ?>
    <input maxlength="7" size="5" type="text" name="sdrn_options[menu_color_hover]" id="sdrn_menu_color_hover_picker"  value="<?php echo $options['menu_color_hover']; ?>" />
    <?php
}


function sdrn_appearance_settings_menu_border_top() {
    $options = get_option('sdrn_options');
    ?>
    <input maxlength="7" size="5" type="text" name="sdrn_options[menu_border_top]" id="sdrn_menu_border_top_picker"  value="<?php echo $options['menu_border_top']; ?>" />
    <?php
}


function sdrn_appearance_settings_menu_border_bottom() {
    $options = get_option('sdrn_options');
    ?>
    <input maxlength="7" size="5" type="text" name="sdrn_options[menu_border_bottom]" id="sdrn_menu_border_bottom_picker"  value="<?php echo $options['menu_border_bottom']; ?>" />
    <?php
}


function sdrn_appearance_settings_menu_border_bottom_show() {
    $options = get_option('sdrn_options');
    ?>
    <select id="sdmn_menu_border_bottom_show" name="sdrn_options[menu_border_bottom_show]" >
        <option <?php if($options['menu_border_bottom_show'] == 'yes') echo 'selected="selected"'; ?>  value="yes">Yes - show bevel border</option>
        <option <?php if($options['menu_border_bottom_show'] == 'no') echo 'selected="selected"'; ?>  value="no">No - hide bevel border</option>
    </select>
    <?php
}



function sdrn_appearance_settings_searchbar_border_color() {
    $options = get_option('sdrn_options');
    ?>
    <input maxlength="7" size="5" type="text" name="sdrn_options[searchbar_border_color]" id="sdrn_searchbar_border_color_picker"  value="<?php echo $options['searchbar_border_color']; ?>" />
    <?php
}


function sdrn_appearance_settings_searchbar_background_color() {
    $options = get_option('sdrn_options');
    ?>
    <input maxlength="7" size="5" type="text" name="sdrn_options[searchbar_background_color]" id="sdrn_searchbar_background_color_picker"  value="<?php echo $options['searchbar_background_color']; ?>" />
    <?php
}






function sdrn_appearance_settings_section_icons() {
    ?>
    <p>
        Mobile.Nav allows for applying custom icons to menu items (links) in the Mobile.Nav menu. <br>
        You can choose from over 360 icons provided by  <a href="http://fortawesome.github.io/Font-Awesome/" target="_blank">font awesome</a> (v4.0.3) or upload your own icon image (23px/23px).<br>
        To apply a custom icon from fontawesome first select it from <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank" >icon library</a> and input the icon sumbol (ex. "<strong>fa-plus</strong>") to appropriet input bellow (leave empty for no icon).<br>
        If icon image is set the fontawesome icon code will be ignored.
    </p>
    <?php
}


function sdrn_appearance_settings_menu_icons() {
    $options = get_option('sdrn_options');
    $logged_in_menu_icons = ($options['custom_for_logged_in'] == 'yes' && $options['logged_in_menu'] > 0)? true : false;
    ?>
    <table id="sdrn_m_icons">
        <thead>
            <tr>
                <th class="imith">Menu item</th>
                <th class="icth">Icon code</th>
                <th class="iccl">Icon color</th>
                <th>Icon image</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $menus = get_terms('nav_menu',array('hide_empty'=>false));
        if($menus) : foreach($menus as $m) :
            if($m->term_id == $options['menu']) $menu = $m;
        endforeach; endif;
        if(is_object($menu)) :
            $menu_items = wp_get_nav_menu_items($menu->term_id);
            $i=0;foreach ($menu_items as $item) {
                $icon_settings = get_item_icon_settings($options['icons_for_items'], $item->ID);
                ?>
                <tr class="sdrn_ii_li">
                    <td>
                        <?php sdrn_item_indentation($item, $menu_items) ?>
                        <input type="hidden" name="sdrn_ii[<?php echo $i ?>][item_id]" value="<?php echo $item->ID ?>">
                    </td>
                    <td>
                        <input type="text" name="sdrn_ii[<?php echo $i ?>][item_icon]" value="<?php echo $icon_settings['item_icon'] ?>">
                    </td>
                    <td>
                        <input maxlength="7" size="5" type="text" name="sdrn_ii[<?php echo $i ?>][color]" id="sdrn_ii_<?php echo $i ?>"  value="<?php echo $icon_settings['color'] ?>" />
                    </td>
                    <td>
                        <input type="hidden" name="sdrn_ii[<?php echo $i ?>][icon_image]" class="cii_image_input" value="<?php echo $icon_settings['icon_image']; ?>">
                        <span style="position:relative">
                            <?php
                            $maybe_hide = 'display: none; ';
                            $src = '';
                            if(isset($icon_settings['icon_image'])) {
                                if(!$icon_settings['icon_image'] == '') {
                                    $maybe_hide = '';
                                    $src = $icon_settings['icon_image'];
                                } 
                            }                            
                            ?>
                            <img style="<?php echo $maybe_hide ?> width:23px; height:23px; margin-bottom:-6px; margin-right:10px;" class="cii_image_prev" src="<?php echo $src ?>" alt="">
                        </span>
                        <input type="button" class="button cii_select_file" value="Choose image" />
                        <span class="description">
                            <?php if(isset($icon_settings['icon_image'])) {
                                if($icon_settings['icon_image'] != '') {
                                    echo ' <a class="remove_cii" href="#" style="margin-left:10px;"> remove</a>';
                                }
                            } ?>
                        </span>
                    </td>
                </tr>
                <?php
            $i++; }
        endif;
        ?>
        <?php
        if($logged_in_menu_icons) {
            echo '<tr class="logged_in_menu_icons_header"><td colspan="4">Icon setting for second menu (menu for logged in users)</td></tr>';

            if($menus) : foreach($menus as $m) :
            if($m->term_id == $options['logged_in_menu']) $menu = $m;
            endforeach; endif;
            if(is_object($menu)) :
                $menu_items = wp_get_nav_menu_items($menu->term_id);
                $i=0;foreach ($menu_items as $item) { 
                    $icon_settings = get_item_icon_settings($options['logmenu_icons_for_items'], $item->ID);
                    ?>
                    <tr class="sdrn_ii_li">
                        <td>
                            <?php sdrn_item_indentation($item, $menu_items) ?>
                            <input type="hidden" name="sdrn_log_ii[<?php echo $i ?>][item_id]" value="<?php echo $item->ID ?>">
                        </td>
                        <td>
                            <input type="text" name="sdrn_log_ii[<?php echo $i ?>][item_icon]" value="<?php echo $icon_settings['item_icon'] ?>">
                        </td>
                        <td>
                            <input maxlength="7" size="5" type="text" name="sdrn_log_ii[<?php echo $i ?>][color]" id="sdrn_log_ii_<?php echo $i ?>"  value="<?php echo $icon_settings['color'] ?>" />
                        </td>
                        <td>
                            <input type="hidden" name="sdrn_log_ii[<?php echo $i ?>][icon_image]" class="cii_image_input" value="<?php echo $icon_settings['icon_image'] ?>">
                            <span style="position:relative">
                                <?php
                                $maybe_hide = 'display: none; ';
                                $src = '';
                                if(isset($icon_settings['icon_image'])) {
                                    if(!$icon_settings['icon_image'] == '') {
                                        $maybe_hide = '';
                                        $src = $icon_settings['icon_image'];
                                    } 
                                }                            
                                ?>
                                <img style="<?php echo $maybe_hide ?> width:23px; height:23px; margin-bottom:-6px; margin-right:10px;" class="cii_image_prev" src="<?php echo $src ?>" alt="">
                            </span>
                            <input type="button" class="button cii_select_file" value="Choose image" />
                            <span class="description">
                                <?php if(isset($icon_settings['icon_image'])) {
                                    if($icon_settings['icon_image'] != '') {
                                        echo ' <a class="remove_cii" href="#" style="margin-left:10px;"> remove</a>';
                                    }
                                } ?>
                            </span>
                        </td>
                    </tr>
                    <?php
                $i++; }
            endif;



        }   
        ?>
        </tbody>
    </table>
    <style type="text/css">
        #sdrn_m_icons {
            border-spacing: 0px;
            border-left:1px solid #E3E3E3;
            border-top:1px solid #E3E3E3;
        }
        #sdrn_m_icons td, #sdrn_m_icons th {
            padding:8px;
            border-right:1px solid #E3E3E3;
            border-bottom:1px solid #E3E3E3;
            background:#fefefe;
            border-spacing: 0px!important;
        }
        #sdrn_m_icons th, #sdrn_m_icons .logged_in_menu_icons_header td { 
            background: #333333;
            color: #BBBBBB;
            border:none;
        }
        #sdrn_m_icons th.icth, #sdrn_m_icons th.imith, #sdrn_m_icons th.iccl {
            border-right:1px solid #BBBBBB;
        }
        #sdrn_m_icons tr.sdrn_ii_tr input[type="text"] {
            margin: 0px;
        }
        #sdrn_m_icons li.sdrn_ii_li .wp-picker-container .wp-color-result {
            margin:0px;
            top:2px;
        }

    </style>
    <?php
}





/**
 * Helper function for marking the menu nested items with "-"
 * @param  object $item menu item object
 * @return string       menu item title with indentation marks.
 */
function sdrn_item_indentation($item, $menu_items) {
    $pre = '';
    $title = $item->title;
    if($item->menu_item_parent > 0) {
        while($item->menu_item_parent > 0) {
            $pre .= '— ';
            foreach ($menu_items as $menu_item) {
                if($menu_item->ID == $item->menu_item_parent) $item = $menu_item;
            }
        }
    }
    echo $pre . $title;
}

/**
 * Helper function for geting the icon settings for right menu item (comapres item ID's - does not use array keys)
 * @param  array $icons_array settings for all icons saved for this menu
 * @param  int $item_id     menu item id
 * @return array             icon settings for current menu item
 */
function get_item_icon_settings($icons_array, $item_id) {
    $item_icons_settings = array(
        'item_id'=>$item_id,
        'item_icon'=>'',
        'color'=>'#F1F1F1',
        'icon_image'=>''
        );
    foreach ($icons_array as $icon_array_item) {
        if($icon_array_item['item_id'] == $item_id) return $icon_array_item;
    }
    return $item_icons_settings;
}











/**
 *
 * VALIDATE & PREPARE FOR SAVING
 *
 * Validates and PREPARES FOR SAVING the values from ALL the inputs
 * @param array $input The array that holds all the inputs from the settings page
 *
 * (the saving is handled by Wordpress)
 *
 */
function sdrn_options_validate($input) {
    global $sdrn_setup; //default settings array

    $options = get_option('sdrn_options');

    //enabled  / dispabled
    if(isset($input['menu'])) {
        $options['enabled'] = $input['enabled'];
    }

    //section "General", option "menu"
    if(isset($input['menu'])) {
        $options['menu'] = $input['menu'];
        if($options['menu'] == false || $options['menu'] == null || $options['menu'] == 0 || $options['menu'] == '') $options['menu'] = '';
    }

    //section "General", option "logged_in_menu"
    if(isset($input['logged_in_menu'])) {
        $options['logged_in_menu'] = $input['logged_in_menu'];
        if($options['logged_in_menu'] == false || $options['logged_in_menu'] == null || $options['logged_in_menu'] == 0 || $options['logged_in_menu'] == '') $options['logged_in_menu'] = '';
    }

    //section "General", option "custom_for_logged_in"
    if(isset($input['custom_for_logged_in'])) {
        $options['custom_for_logged_in'] = $input['custom_for_logged_in'];
    }

    if(isset($input['menu_symbol_pos'])) {
       $options['menu_symbol_pos'] = $input['menu_symbol_pos'];
    }

    //section "General", option "bar_title"
    if(isset($input['bar_title'])) {
        $options['bar_title'] = trim($input['bar_title']);
        if($options['bar_title'] == false || $options['bar_title'] == '') $options['bar_title'] = '';
    }

    //section "General", option "bar_logo"
    if(isset($input['bar_logo'])) {
        $options['bar_logo'] = trim($input['bar_logo']);
        if($options['bar_logo'] == false || $options['bar_logo'] == '') $options['bar_logo'] = '';
    }

    if(isset($input['nesting_icon'])) {
        $options['nesting_icon'] = trim($input['nesting_icon']);
        if($options['nesting_icon'] == false || $options['nesting_icon'] == '') $options['nesting_icon'] = '';
    }

    if(isset($input['nesting_icon_open'])) {
        $options['nesting_icon_open'] = trim($input['nesting_icon_open']);
        if($options['nesting_icon_open'] == false || $options['nesting_icon_open'] == '') $options['nesting_icon_open'] = '';
    }

    //section "General", option "expand_sub_with_parent"
    if(isset($input['expand_sub_with_parent'])) {
        $options['expand_sub_with_parent'] = $input['expand_sub_with_parent'];
    }

    //section "General", option "from_width"
    if(isset($input['from_width'])) {
        $options['from_width'] = $input['from_width'];
    }

    //section "General", option "position"
    if(isset($input['position'])) {
        $options['position'] = $input['position'];
    }

    //section "General", option "how_wide"
    if(isset($input['how_wide'])) {
        $options['how_wide'] = $input['how_wide'];
    }

    //section "General", option "swipe_actions"
    if(isset($input['swipe_actions'])) {
        $options['swipe_actions'] = $input['swipe_actions'];
    }

    //section "General", option "hide"
    if(isset($input['hide'])) {
        $sel = explode(',', trim($input['hide']));
        foreach($sel as $s) {
            $selectors[] = trim($s);
        }
        $options['hide'] = $selectors;
    } else {
    }

    //section "General", option "zooming"
    if(isset($input['zooming'])) {
        $options['zooming'] = $input['zooming'];
    }

    //section "General", option "animation"
    if(isset($input['animation'])) {
        $options['animation'] = $input['animation'];
    }

    //section "General", option "searchbar"
    if(isset($input['searchbar'])) {
        $options['searchbar'] = $input['searchbar'];
    }

    //section "General", option "searchbar_label"
    if(isset($input['searchbar_label'])) {
        $options['searchbar_label'] = trim($input['searchbar_label']);
        if($options['searchbar_label'] == false || $options['searchbar_label'] == '') $options['searchbar_label'] = '';
    }



    //section "appearance", option "bar_bgd"
    if(isset($input['bar_bgd'])) {
        $options['bar_bgd'] = $input['bar_bgd'];
    }

    //section "appearance", option "bar_color"
    if(isset($input['bar_color'])) {
        $options['bar_color'] = $input['bar_color'];
    }

    //section "appearance", option "menu_bgd"
    if(isset($input['menu_bgd'])) {
        $options['menu_bgd'] = $input['menu_bgd'];
    }

    //section "appearance", option "menu_color"
    if(isset($input['menu_color'])) {
        $options['menu_color'] = $input['menu_color'];
    }

    //section "appearance", option "menu_color_hover"
    if(isset($input['menu_color_hover'])) {
        $options['menu_color_hover'] = $input['menu_color_hover'];
    }

    //section "appearance", option "menu_border_top"
    if(isset($input['menu_border_top'])) {
        $options['menu_border_top'] = $input['menu_border_top'];
    }


    //section "appearance", option "menu_border_bottom"
    if(isset($input['menu_border_bottom'])) {
        $options['menu_border_bottom'] = $input['menu_border_bottom'];
    }

    if(isset($input['menu_border_bottom_show'])) {
        $options['menu_border_bottom_show'] = $input['menu_border_bottom_show'];
    }


    if(isset($_POST['sdrn_ii'])) {
        $options['icons_for_items'] = $_POST['sdrn_ii'];
    }

    if(isset($_POST['sdrn_log_ii'])) {
        $options['logmenu_icons_for_items'] = $_POST['sdrn_log_ii'];
    }

    if(isset($input['searchbar_border_color'])) {
        $options['searchbar_border_color'] = $input['searchbar_border_color'];
    }

    if(isset($input['searchbar_background_color'])) {
        $options['searchbar_background_color'] = $input['searchbar_background_color'];
    }

    //save only the options that were changed
    $options = array_merge(get_option('sdrn_options'), $options);

    //echo '<pre>'; print_r($options); echo '</pre>';

    return $options;
}







