<?php
$url = parse_url($_SERVER['REQUEST_URI']);
if(isset($_GET['id'])){
    $vid = $_GET['id'];
    $ch = curl_init();
    $str ='https://api.youtubemultidownloader.com/video?url=https://www.youtube.com/watch?v='.$vid;
    curl_setopt($ch, CURLOPT_URL, $str);
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    $output = curl_exec($ch);
    $data = json_decode($output, true);
    die($data["format"][0]["url"]);
} else {
   die("error");
}
