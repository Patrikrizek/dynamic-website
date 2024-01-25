<?php 
require "pripojeni.php";
if(isset($_GET['page'])) {
	$php=trim(htmlspecialchars(strip_tags($_GET['page'])));
} else {
    // set proper default value if it was not set
    $php = 'index';
}
$dotaz='SELECT * FROM texty WHERE publikovan="1" AND urlnazev="'.$php.'"';		
$vysledek=mysqli_query($conn, $dotaz);
$zaznam=mysqli_fetch_array($vysledek);
if(!isset($zaznam['nazev'])) {
	$zaznam['nazev'] = "";
}

if($zaznam['nazev']!="") {
	$nazev=$zaznam['nazev'];
	$text=$zaznam['text'];
	$klicovaslova=$zaznam['klicovaslova'];
	$title=$zaznam['nazev'].' | Programování WWW stránek pro začátečníky';
	$metapopis=$zaznam['metapopis'];
};

if(!isset($nazev)) {
	$nazev = "";
}

if($nazev == "") {
	echo '<html><meta http-equiv="REFRESH" content="0;index.php?page=error404"></html>'; die();
};
?>
