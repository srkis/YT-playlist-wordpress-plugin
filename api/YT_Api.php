<?php



class YT_Api
{


    public function getPlayListVideos($playlistID ,$channelID,$apiKey)
    {

        if ($channelID == '' || $apiKey == '') {
            echo "<p style='color: #985e42;'><strong>You're not provide API Key or Channel ID, so default is used.";
            echo "<a href='https://github.com/srkis' target='_blank'>&nbsp; Click here to see how to get API Key and Channel ID</a></p> </strong>";

            $channelID = 'UCEpdXv6Ick3WSkXa9eX03_A'; //UCEpdXv6Ick3WSkXa9eX03_A
            $apiKey = 'AIzaSyDHvX_7ah-xEaoMQKclf2fNanDSJa6FVO8';

        }


        $baseUrl = 'https://www.googleapis.com/youtube/v3/';
        $yt_getStyle = $this->getStyle();
        $yt_video_limit = $yt_getStyle[0]->yt_video_limit;

        $params = array(
            'id' => $channelID,
            'part' => 'contentDetails',
            'key' => $apiKey

        );
        $url = $baseUrl . 'channels?' . http_build_query($params);


        $json = json_decode(file_get_contents($url), true);

        $params = array(
            'part' => 'snippet',
            'playlistId' => $playlistID,
            'key' => $apiKey
        );


        if (is_null($params['playlistId']) || (string)$params['playlistId'] == '') {
            return $this->_showChannelVideos($apiKey,$channelID);

        } else {

            $i = 1;
            $url = $baseUrl . 'playlistItems?' . http_build_query($params);

            $json = json_decode(file_get_contents($url), true);

            $videos = [];

            foreach ($json['items'] as $video)

                $videos[] = $video['snippet']['resourceId']['videoId'];

            while (isset($json['nextPageToken'])) {
                $nextUrl = $url . '&pageToken=' . $json['nextPageToken'];
                $json = json_decode(file_get_contents($nextUrl), true);
                foreach ($json['items'] as $video)

                    $videos[] = $video['snippet']['resourceId']['videoId'];

            }

            $nizVideo = array();
            foreach ($videos as $noviVideo){
                $nizVideo[] = $noviVideo;
                if($i++ == $yt_video_limit)break;
            }
            return $nizVideo;
        }
    }



    private function _showChannelVideos($apiKey,$channelID)
    {
        $baseUrl = 'https://www.googleapis.com/youtube/v3/';
        $yt_getStyle = $this->getStyle();
        $yt_video_limit = $yt_getStyle[0]->yt_video_limit;

        $params = array(
            'key' => $apiKey,
            'channelId' => $channelID,
            'part' => 'snippet',
           'order' => 'date'

        );
        $url = $baseUrl . 'search?' . http_build_query($params);

        $json = json_decode(file_get_contents($url), true);



        $videos = array(); // pravimo niz

        foreach ($json['items'] as $video => $id){

            if(! isset($id['id']['videoId'])) {

            }else{

                $videos[] = $id['id']['videoId'];

            }

        }

        while (isset($json['nextPageToken'])) {

            $nextUrl = $url . '&pageToken=' . $json['nextPageToken'];

            $json = json_decode(file_get_contents($nextUrl), true);

            foreach ($json['items'] as $video => $id){

                if(! isset($id['id']['videoId'])) {

                }else{

                    $videos[] = $id['id']['videoId'];
                }

            }

        }

        $removedEmptyKeys = array_filter($videos);
        $fromZero = array_values($removedEmptyKeys);

        $i = 1;

        $nizArr = array();
        foreach ($fromZero as $niz) {

                $nizArr[] = $niz;
            if($i++ == $yt_video_limit)break;


        }
        return array_values($nizArr);

    }


    public function getStyle()
    {
        global $wpdb;
        $tablename = $wpdb->prefix . 'yt_playlist_gallery';
        $getStyle =  $wpdb->get_results("SELECT * FROM $tablename");

        if ($wpdb->num_rows > 0) {

            return $getStyle;

        }

    }


}
