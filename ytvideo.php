<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
/*
Plugin Name:YT Playlist gallery
Plugin URI: https://github.com/srkis
Description:  Plugin koji prikazuje youtube video galeriju. Plugin je napravljen za prikazivanje video galerije u sidebaru.
Author: Srdjan Stojanovic
Version: 1.0
Author URI: http://www.srdjan.icodes.rocks/

*/
ob_start();

include_once('api/YT_Api.php');

include_once dirname( __FILE__ ) . '/includes/yt_playlist_gallery.php';


function ytvideo_install()
{

global $wpdb;
return true;
}





function ytvideo_style()
{


    wp_register_style('css',plugin_dir_url(__FILE__).'style/style.css');
    wp_enqueue_style('css');

    wp_register_style('gallery',plugin_dir_url(__FILE__).'style/gallery.css');
    wp_enqueue_style('gallery');

    wp_enqueue_script( 'script', plugins_url('scripts/js.js', __FILE__), array('jquery'));


}

/*Iskljucivanje plugina */
function ytvideo_uninstall()
{
    global $wpdb;
    include_once("includes/yt_playlist_gallery_uninstall.php");

    yt_playlist_gallery_uninstall();
}





//add_action('admin_menu','menu');

add_action( 'wp_enqueue_scripts', 'ytvideo_style');


//add_action( 'widgets_init', 'my_widget_init' );



class wp_my_plugin extends WP_Widget {

    // constructor
    function wp_my_plugin() {
        parent::__construct(false, $name = __('YT video gallery', 'wp_widget_plugin') );
               // WP_Widget(false, $name = __('YT video gallery', 'wp_widget_plugin') );


    }


    function form($instance) {



if($instance) {
    $title = esc_attr($instance['title']);
    $channelID = esc_attr($instance['channelID']);
    $playlistID = esc_attr($instance['playlistID']);
    $apiKey = esc_attr($instance['apiKey']);


} else {

    $title = '';
    $playlistID = '';
    $channelID = '';
    $apiKey = '';
}
?>
    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id('playlistID'); ?>"><?php _e('PlayList iD:', 'wp_widget_plugin'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('playlistID'); ?>" name="<?php echo $this->get_field_name('playlistID'); ?>" type="text" value="<?php echo $playlistID; ?>" />
    </p>

    <p>
        <label for="<?php echo $this->get_field_id('channelID'); ?>"><?php _e('Channel ID:', 'wp_widget_plugin'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('channelID'); ?>" name="<?php echo $this->get_field_name('channelID'); ?>" type="text" value="<?php echo $channelID; ?>" />
    </p>

        <p>
            <label for="<?php echo $this->get_field_id('apiKey'); ?>"><?php _e('API Key:', 'wp_widget_plugin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('apiKey'); ?>" name="<?php echo $this->get_field_name('apiKey'); ?>" type="text" value="<?php echo $apiKey; ?>" />
        </p>




<?php


    }

    function update($new_instance, $old_instance) {

          $instance = $old_instance;
        // Fields
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['playlistID'] = strip_tags($new_instance['playlistID']);
        $instance['channelID'] = strip_tags($new_instance['channelID']);
        $instance['apiKey'] = strip_tags($new_instance['apiKey']);

        return $instance;
    }

    function widget($args, $instance)
    {
        include_once("display_plugin.php");

        display_plugin($args, $instance);



    }

 }




function admin_js() {

    wp_register_script('admin_js', plugin_dir_url(__FILE__).'scripts/foradmin.js',  array('jquery'));
    wp_enqueue_script('admin_js');
}


add_action('admin_enqueue_scripts', 'admin_js');


register_activation_hook(__FILE__, 'ytvideo_install');

register_deactivation_hook(__FILE__, 'ytvideo_uninstall');

register_activation_hook(__FILE__, 'yt_playlist_gallery_page');

add_filter('widget_text','do_shortcode');

add_action('widgets_init', create_function('', 'return register_widget("wp_my_plugin");'));

return ob_get_clean();