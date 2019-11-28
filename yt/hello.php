<?php
$ch = curl_init();
$str ='https://api.youtubemultidownloader.com/video?url=https://www.youtube.com/watch?v=AD6DHSTjiwI';
curl_setopt($ch, CURLOPT_URL, $str);
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
$output = curl_exec($ch);
var_dump( $output );