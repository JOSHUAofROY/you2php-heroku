<?php
define('USER_AGENT', $_SERVER['HTTP_USER_AGENT'] ?? 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0');

require_once('new.php');
$n = new newVideo();
$url = "https://r1---sn-aigzrn7z.googlevideo.com/videoplayback?expire=1574965459&ei=c7zfXea9AtDa1wbZ77bACg&ip=54.78.14.128&id=o-ADBoGGHCa4_J3gc6QXqMJi7YDSxxxOEN39EeI5CwJt8S&itag=22&source=youtube&requiressl=yes&mm=31%2C26&mn=sn-aigzrn7z%2Csn-4g5edn7s&ms=au%2Conr&mv=u&mvi=0&pl=22&mime=video%2Fmp4&ratebypass=yes&dur=1500.078&lmt=1574651734083175&mt=1574943725&fvip=1&fexp=23842630&c=WEB&txp=5535432&sparams=expire%2Cei%2Cip%2Cid%2Citag%2Csource%2Crequiressl%2Cmime%2Cratebypass%2Cdur%2Clmt&sig=ALgxI2wwRAIgYwm4x7E5YcvRJRLP8QrhoFWhQGXqfA7a9ZPqlT0OkUQCIEAtq_gP3xkiZ3EwFc7qdr1UfL1xs2X6xiFqhOflQoc1&lsparams=mm%2Cmn%2Cms%2Cmv%2Cmvi%2Cpl&lsig=AHylml4wRQIgapdoZl6vQTlh6LsYaSuzTWWKb98aP2gc8E_rPeQxFPkCIQDxcelmJ-Js7gS-fyYpgoLTo7zvPnL6WpZ2htEA04FzeA%3D%3D";

// request headers
$headers = array(
    'User-Agent: ' . USER_AGENT
);

if (isset($_SERVER['HTTP_RANGE'])) {
    $headers[] = 'Range: ' . $_SERVER['HTTP_RANGE'];
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);

// we deal with this ourselves
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
curl_setopt($ch, CURLOPT_HEADER, 0);

// whether request to video success
$headers = '';
$headers_sent = false;
$success = false;

curl_setopt($ch, CURLOPT_HEADERFUNCTION, function ($ch, $data) use (&$headers, &$headers_sent) {

    $headers .= $data;

// this should be first line
    if (preg_match('@HTTP\/\d\.\d\s(\d+)@', $data, $matches)) {
        $status_code = $matches[1];

// status=ok or partial content
        if ($status_code == 200 || $status_code == 206) {
            $headers_sent = true;
            header(rtrim($data));
        } elseif ($status_code == 403) {
            echo '<pre>403 Forbidden :(<br>Try other link...';
        }

    } else {

        // only headers we wish to forward back to the client
        $forward = array('content-type', 'content-length', 'accept-ranges', 'content-range');

        $parts = explode(':', $data, 2);

        if ($headers_sent && count($parts) == 2 && in_array(trim(strtolower($parts[0])), $forward)) {
            header(rtrim($data));
        }
    }

    return strlen($data);
});

// if response is empty - this never gets called
curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($curl, $data) use (&$headers_sent) {

    if ($headers_sent) {
        echo $data;
        flush();
    }

    return strlen($data);
});

$res = @curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);