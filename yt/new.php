<?php
class newVideo {
    public function getLink($id) {
        $ch = curl_init();
        $str ='https://api.youtubemultidownloader.com/video?url=https://www.youtube.com/watch?v='.$id;
        curl_setopt($ch, CURLOPT_URL, $str);
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        $output = curl_exec($ch);
        $data = json_decode($output, true);
        if(sizeof($data["format"])>0) {
            return $data["format"];
        } else {
            return "https://myprintln.herokuapp.com/yt/movie.mp4";
        }
    }
}