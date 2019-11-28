<?php
$url = parse_url($_SERVER['REQUEST_URI']);
if(isset($_GET['id'])){
    $res=file_get_contents("https://myprintln.herokuapp.com/yt/hello.jsp?id=".$_GET['id']);
    die($res);
} else {
    die("https://myprintln.herokuapp.com/yt/movie.mp4");
}