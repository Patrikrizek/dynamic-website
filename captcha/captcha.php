<?php
session_start();
header ("Content-type: image/png");
$kod = rand(100,999);
$_SESSION['captcha'] = $kod;
$obrazek = imagecreate(200, 50);
imagecolorallocate ($obrazek, 255, 255, 255);
$seda = imagecolorallocate($obrazek, 0, 120, 100);
$font = "OpenSansBold.ttf";

// Generuj nahodne cary, rand()%50 = rand(0,50) = vyska obrazyku
for($i=0;$i<10;$i++) {
    imageline($obrazek, 0, rand()%50, 200, rand()%50, $seda);
}

// Generuj nahodne tecky, rand()%200 = rand(0,200) = sirka obrazku
for($i=0;$i<1000;$i++) {
    imagesetpixel($obrazek,rand()%200,rand()%50,$seda);
}  
//imagestring($obrazek, 5, 80, 20,  $_SESSION['captcha'],  $seda);

// Vloz text do obrazku
imagettftext($obrazek, 25, 0, 70, 38, $seda, $font, $_SESSION['captcha']);

imagepng ($obrazek);
?>
