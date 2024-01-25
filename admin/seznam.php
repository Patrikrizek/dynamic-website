<?php
if(isset($volej)!="ano"){
	echo 'Musíte se přihlásit.';
	die();
}
require "../pripojeni.php";
$dotaz='SELECT * FROM texty ORDER BY texty.zobrazvmenu DESC';		
$vysledek=mysqli_query($conn, $dotaz);

echo '<br>'; // due to BOM mark > php file or database in diferent UTF formation

while($zaznam=mysqli_fetch_array($vysledek)){
	echo '<div style="display: flex; align-items: center;">
	<a href="index.php?page=texty&id='.$zaznam['idtextu'].'">'.$zaznam['nazev'].'</a>
	<p style="margin: 0px 10px 0px 10px";>|<p/>
	<a href="../index.php?page='.$zaznam['urlnazev'].'" target="_blank">Nahled stranky: '.$zaznam['nazev'].'</a>
	<p style="margin: 0px 10px 0px 10px";>|<p/>
	<p><b>Publikovan:</b> ';
	if($zaznam['publikovan'] == "0") {echo 'Ne </p>';} else {echo 'Ano </p>';}
	if($zaznam['zobrazvmenu'] == "1") {echo '<p style="margin: 0px 10px 0px 10px";>|<p/> <p><b>Zobrazit v menu:</b> Ano </p>';} else {echo '</p>';}
	if($zaznam['zobrazvmenu'] == "1") {echo '<p style="margin: 0px 10px 0px 10px";>|<p/> <p><b>Poradi v menu:</b> '.$zaznam['poradimenu'].'</p></div></br>';} else {echo '</p></div></br>';}
}
?>

<a href="index.php?page=texty&id=new">Přidat nový text</a><br><br><br><br><br>
<a href="index.php">Zpet do Dashboard</a>
