<?php

function yt_playlist_gallery_uninstall(){
    	global $wpdb; //global variable for interaction with wp database

	require_once( ABSPATH. 'wp-admin/includes/upgrade.php' );
        $table_name = $wpdb->prefix . "yt_playlist_gallery";

        $sql = "DROP TABLE IF EXISTS $table_name;";
        $wpdb->query($sql);
        delete_option("my_plugin_db_version");

}