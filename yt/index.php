<?php

/***********************************************
 * 
 * PHP-Youtube Downloader
 * 
 * Owner: Yehuda Eisenberg.
 * 
 * Mail: Yehuda.telegram@gmail.com
 * 
 * Link: https://yehudae.ga
 * 
 * Telegram: @YehudaEisenberg
 * 
 * GitHub: https://github.com/YehudaEi
 *
 * License: MIT - אסור לעשות שימוש ציבורי, חובה להשאיר קרדיט ליוצר
 * 
************************************************/

$url = parse_url($_SERVER['REQUEST_URI']);
//if(strpos($url['path'], "movie.mp4") !== (strlen($url['path']) - 9))
    //header("Location: ".substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/"))."/movie.mp4");

if(!isset($_GET['roy'])){
    header("Location: ".substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/"))."/movie.mp4"); 
    die();
}
else{
    /*$q = parse_url($_GET['roy'], PHP_URL_QUERY);
    $q = explode("&", $q);
    
    foreach ($q as $str){
        if(strpos($str, "v=") === 0){
            $id = str_replace("v=", "", $str);
            break;
        }
    }*/
    
    $id = $_GET['roy'];

    if(isset($id) && !empty($id)){
        require_once('YTDL.php');
        $yt = new YouTubeDownloader();
        
        $file = 'logs' . '/' . date('Y-m-d') . '.log';
        $write = str_pad($_SERVER['REMOTE_ADDR'] . ', ' , 15) . date('d/M/Y - H:i:s') . ', ' . 'YouTube: '.$id . "\r\n";
        file_put_contents($file, $write, FILE_APPEND);
        
        $yt->stream("https://www.youtube.com/watch?v=".$id);
    }
    else {
        header("Location: ".substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/"))."/movie.mp4"); 
        die();
    }
}
