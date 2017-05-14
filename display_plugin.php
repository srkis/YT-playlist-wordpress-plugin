<?php

function display_plugin($args, $instance)

    {
        extract($args, EXTR_SKIP);
        extract( $instance );

        $title = apply_filters('widget_title', $instance['title']);
        $playlistID = $instance['playlistID'];
        $channelID = $instance['channelID'];
        $apiKey = $instance['apiKey'];
        echo $before_widget;
        echo '<div class="widget-text wp_widget_plugin_box">';

        if ( $title ) {
            echo $before_title . $title . $after_title;
        }


            $yt_api = new YT_Api();

            $playListVideos =  $yt_api->getPlayListVideos($playlistID, $channelID,$apiKey);

            $yt_style = $yt_api->getStyle();
            $yt_background = $yt_style[0]->yt_background;
            $yt_height = $yt_style[0]->yt_height;
            $yt_width = $yt_style[0]->yt_width;


        foreach ($playListVideos as $idVideo => $idV){

        }


            ?>

            <div class="ytwidget"style="position:absolute; background-color: <?php echo $yt_background ?>" >

            <div style="padding:10px; " >
                <?php  echo wp_oembed_get( "https://www.youtube.com/watch?v=" . $playListVideos[0], array('width'=>$yt_width, 'height' =>$yt_height) ); ?>

            </div>

        <?php


        unset($playListVideos[0]);
        foreach ($playListVideos as $videoId)

        { ?>

            <div class="yt-tumb" style="float: left; padding: 0 10px; 20px; 0px; position:relative;" >

                <?php echo  wp_oembed_get('https://www.youtube.com/watch?v='.$videoId, array('width'=>210, 'height' =>250));?>

            </div>

        <?php } ?>

        </div>

        <?php


        if( $channelID ) {
           // echo '<p class="wp_widget_plugin_textarea">'.$channelID.'</p>';
        }
        echo '</div>';
        // echo $after_widget;

    }
