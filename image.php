<?php
$number=$_GET['number']?? "";

$file="images/PNGイメージ ";
if($number==""){
    $file="images/PNGイメージ";
}
$file.=$number;
$file.=".png";

if (file_exists($file)) {
    header("Content-type: image/png");
    readfile($file);
} else {
    header("HTTP/1.1 404 Not Found");
    include ('404.php');
}


