<?php
define('USER_AGENT', $_SERVER['HTTP_USER_AGENT'] ?? 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0');

require_once('new.php');
$n = new newVideo();
$url = "https://r3---sn-oguesnsy.googlevideo.com/videoplayback?api=youtubemultidownloader.com&expire=1574964189&ei=fbffXaKzGsXugAeMsZeIBA&ip=2a03%3Ab0c0%3A3%3Ae0%3A%3Ae6%3Af001&id=o-AKtrUIA_iSgtqcnjC_PZbVCRpJuWJF2TuXRt8Ys_KcY3&itag=135&aitags=133%2C134%2C135%2C160%2C242%2C243%2C244%2C278&source=youtube&requiressl=yes&mime=video%2Fmp4&gir=yes&clen=59725326&dur=1429.799&lmt=1568011277396383&fvip=3&keepalive=yes&fexp=23842630&beids=9466587&txp=5432432&sparams=expire%2Cei%2Cip%2Cid%2Caitags%2Csource%2Crequiressl%2Cmime%2Cgir%2Cclen%2Cdur%2Clmt&sig=ALgxI2wwRQIhAMdrS6SG95OK6s6EbZMF7lxvwRJ4a5-kRp8YV2LY0ztXAiAzD1BqXP7xuHj6DAzv2f-FnXyKSweL0tPSPhTlCYPdug%3D%3D&title=%E3%80%90%E6%95%A3%E4%BA%BA%E3%80%91%E5%8F%B2%E4%B8%8A%E6%9C%80%E9%9A%BEFC%E6%B8%B8%E6%88%8F%E6%A2%A6%E5%B9%BB%E5%A4%8D%E5%88%BB+%E6%89%93%E5%93%AD%E5%88%B0%E6%B5%81%E6%B3%AA%E3%80%8A+i+wanna+eat+sandwich%E3%80%8B%7C+%E9%80%8D%E9%81%A5%E6%95%A3%E4%BA%BA&cms_redirect=yes&mip=81.90.190.50&mm=31&mn=sn-oguesnsy&ms=au&mt=1574942478&mv=m&mvi=2&pl=24&lsparams=mip,mm,mn,ms,mv,mvi,pl&lsig=AHylml4wRQIgbSpE15eGsdTh0MIlH1Hzy4SzHeqtFWvU7WibK-WoIyYCIQC0iKNLe25spNW9g2tDOgpKYK1t581cnGhCBLkwqN46HQ==";

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