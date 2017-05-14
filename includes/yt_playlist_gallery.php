<?php
function yt_playlist_gallery_page(){

	global $wpdb;


    $table_name = $wpdb->prefix . "yt_playlist_gallery";
    $title = "YT-Video-Gallery-BY-Srki-(https://github.com/srkis)";

    $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
      id int(11) NOT NULL AUTO_INCREMENT,
      yt_title varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      yt_background varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      yt_height varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      yt_width varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      yt_video_limit varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      PRIMARY KEY  (id)
    ) $charset_collate;

    INSERT INTO $table_name (id, yt_title,yt_background,yt_height,yt_width, yt_video_limit) VALUES ('1', 'YT-Video-Gallery-BY-Srki-(https://github.com/srkis)', 'white', '250', '550','') ";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

    }


function yt_playlist_gallery(){

    add_menu_page('YT Playlist Gallery', 'YT Playlist Gallery', 'manage_options', 'yt-playlist-gallery-options', 'yt_playlist_gallery_settings_page');

}

add_action('admin_menu', 'yt_playlist_gallery');



function register_yt_playlist_gallery_settings() {
    //register our settings
    register_setting( 'yt-playlist-gallery-settings-group', 'background' );
    register_setting( 'yt-playlist-gallery-settings-group', 'width' );
    register_setting( 'yt-playlist-gallery-settings-group', 'height' );
    register_setting( 'yt-playlist-gallery-settings-group', 'yt_limit' );
}

function yt_playlist_gallery_settings_page() {
    ?>
    <div class="wrap">
        <h1>YT Playlist Gallery by Srki</h1>
        <p><a href="https://github.com/srkis" target="_blank">YT plugin on GitHub</a> </p>
        <p>Simple light plugin for your YouTube playlist or channel videos</p>

        <?php
        $yt_api = new YT_Api();

        $yt_style = $yt_api->getStyle();
        $yt_background = $yt_style[0]->yt_background;
        $yt_height = $yt_style[0]->yt_height;
        $yt_width = $yt_style[0]->yt_width;
        $yt_video_limit = $yt_style[0]->yt_video_limit;

        ?>

        <h4>Current background color: &nbsp; <?php echo $yt_background ?></h4>
        <h4>Current Width: &nbsp; <?php echo $yt_width ?></h4>
        <h4>Current Height: &nbsp; <?php echo $yt_height ?></h4>
        <h4>Current Video Limit: &nbsp; <?php echo $yt_video_limit = (!empty($yt_video_limit)) ? $yt_video_limit : "No limit"; ?></h4>

        <form method="post" action="">
            <?php settings_fields( 'yt-playlist-gallery-settings-group' ); ?>
            <?php do_settings_sections( 'yt-playlist-gallery-settings-group' ); ?>
            <table class="form-table">
                <h2>You can change default settings here: </h2>
                <p style="color: #9f1818"><strong>Note: You can show all playlist or  channel videos if you leave blank video limit field.</strong></p>
                <tr valign="top">
                    <th scope="row">Background color</th>
                    <td><input type="text" id="background" name="background" value="<?php echo esc_attr( get_option('background') ); ?>" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Width</th>
                    <td><input type="text" name="width" id="width" value="<?php echo esc_attr( get_option('width') ); ?>" /></td>
                  </tr>

                <tr valign="top">
                    <th scope="row">Height</th>
                    <td><input type="text" name="height" id="height" value="<?php echo esc_attr( get_option('height') ); ?>" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Video Limit</th>
                    <td><input type="text" name="yt_limit" id="yt_limit" value="<?php echo esc_attr( get_option('yt_limit') ); ?>" /></td>
                </tr>

            </table>
            <?php submit_button( 'Save Changes', 'primary', 'save', '' ) ?>

        </form>

        <br>
         <div id="success" style="color:green;font-weight: bold"></div>
            <div id="error" style="color:red;font-weight: bold"></div>
    </div>


    <?php } ?>
