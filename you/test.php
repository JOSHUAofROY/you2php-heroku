<?php
require 'Youtube.php';
$url = parse_url($_SERVER['REQUEST_URI']);
if(!isset($_GET['roy'])){
    echo "nonono";
} else {
$youtube = new Zarkiel\Media\Youtube();
$links = $youtube->getDownloadLinks($_GET['roy']);
print_r($links);
}
