<?php

        $parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
        require_once($parse_uri[0] . 'wp-load.php');
        global $wpdb;


        if (isset($_POST['action']) && $_POST['action'] == 'change_style') {

            $title = "YT-Video-Gallery-BY-Srki-(https://github.com/srkis)";
            $width = $_POST['width'];
            $height = $_POST['height'];
            $background = $_POST['background'];
            $yt_limit = $_POST['yt_limit'];
            if($width == '' || $background == '' || $height == '')
            {
                $result = array(
                    "status" => "fail",
                    "message" => "Error! Fields can not be empty!");
                header('Content-type: application-json; charset=utf8;');
                echo json_encode($result);
                die;

            }

            $tablename = $wpdb->prefix . 'yt_playlist_gallery';

            $data = array(
                'yt_background' => $background,
                'yt_height' => $height,
                'yt_video_limit' => $yt_limit,
                'yt_width' => $width);

            $result = array();
            $wpdb->get_results("SELECT * FROM $tablename");

            if ($wpdb->num_rows > 0) {


                $style = $wpdb->update(
                    $wpdb->prefix . 'yt_playlist_gallery',
                    array('yt_width' => $width, 'yt_height' => $height, 'yt_background' => $background, 'yt_video_limit' =>$yt_limit), array("yt_title" => $title));    // column & new value

            } else {

                $style = $wpdb->insert($tablename, $data);
            }


            switch ($style) {

                case '1':

                    $result = array(
                        "status" => "success",
                        "message" => "Success! Your changes has beed updated."

                    );

                    header('Content-type: application-json; charset=utf8;');
                    echo json_encode($result);

                    break;

                case '0' :

                    $result = array(
                        "status" => "success",
                        "message" => "Success! Your changes has beed inserted.");
                    header('Content-type: application-json; charset=utf8;');

                    echo json_encode($result);
                    break;

                default:
                    $result = array(
                        "status" => "fail",
                        "message" => "Error! Somethig wrong, please try again!");
                    header('Content-type: application-json; charset=utf8;');
                    echo json_encode($result);
                    die;

            }

        }





