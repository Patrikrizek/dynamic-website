<?php
require "pripojeni.php";
echo '<br/><strong>Fotogalerie:</strong><br/>';
$dotaz='SELECT * FROM foto order by id asc';		
$vysledek=mysqli_query($conn, $dotaz);
while($zaznam=mysqli_fetch_array($vysledek)){
	echo '<a href="foto/'.$zaznam['nazev'].'" target=_blank"><img src="foto/mini/'.$zaznam['nazev'].'" /></a>';
}
?>