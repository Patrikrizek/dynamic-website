<?php
if($volej!="ano"){
	echo 'Musíte se přihlásit.';
	die();
}
?>
<form action="" method="post" enctype="multipart/form-data">
	<label for="soubor">Soubor:</label> <input type="file" name="soubor">
    <input type="submit" value="Nahrát na server">
</form>
<?php
require "../pripojeni.php";
if(isset($_FILES['soubor']) && $_FILES['soubor']!="")  {
	list($sirka, $vyska, $typ) =  getimagesize($_FILES['soubor']['tmp_name']);
	switch ($typ) {
	  case IMAGETYPE_GIF:
		$image = imagecreatefromgif($_FILES['soubor']['tmp_name']) or
		die('Formát souboru nie je podporovaný.');
		$pripona = '.gif';
		break;
	  case IMAGETYPE_JPEG:
		$image = imagecreatefromjpeg($_FILES['soubor']['tmp_name']) or
		die('Formát souboru nie je podporovaný.');
		$pripona = '.jpg';
		break;
	  case IMAGETYPE_PNG:
		$image = imagecreatefrompng($_FILES['soubor']['tmp_name']) or
		die('Formát souboru nie je podporovaný.');
		$pripona = '.png';
		break;
	  default:
		die('Formát souboru nie je podporovaný.');
	}
		
	$imagename=str_replace($pripona, '.jpg', $_FILES['soubor']['name']);
	
	if(file_exists("../foto/mini/".$imagename)){
		echo '<div id="err">Obrázek s názvem "'.$imagename.'" už v galerii existuje.</div>';
	} else {
		if($vyska <= 70) { $pomer=1; } else { $pomer = $vyska / 70; };
		$thumb_sirka=round($sirka/$pomer);
		$thumb_vyska=round($vyska/$pomer);
		$thumb = imagecreatetruecolor($thumb_sirka, $thumb_vyska);
		imagecopyresampled($thumb, $image, 0, 0, 0, 0, $thumb_sirka, $thumb_vyska, $sirka, $vyska);
		// adresář foto/mini/ musí mít nastaveny práva pro zápis
		imagejpeg($thumb, "../foto/mini/".$imagename);
		imagedestroy($thumb);
	
		$watermark = imagecreatefrompng("logo.png");
		$pruhledna = imagecolorallocate($watermark, 0, 0, 0);
		imagecolortransparent($watermark, $pruhledna);
		$x=$sirka/2-260/2;
		$y=$vyska/2-66/2;
		imagecopymerge($image, $watermark, $x, $y, 0, 0, 800, 550, 20);	
		// adresář foto/ musí mít nastaveny práva pro zápis
		imagejpeg($image, "../foto/".$imagename);
		imagedestroy($image);	
		
		$dotaz = 'INSERT INTO foto (nazev) VALUES ("'.$imagename.'")';
		$vysledky = mysqli_query($conn, $dotaz) or die(mysqli_error($db));
		if($vysledky) {
			echo '<div id="ok">Obrázek "'.$imagename.'" byl úspěšně vložen do fotogalerie.</div>';
		} else {
			echo '<div id="err">Obrázek "'.$imagename.'" se do databázi nepodařilo vložit.</div>';
		}
	}
}


echo '<br/><strong>Obsah fotogalerie:</strong><br/>';

echo '<form action="" method="post">';

echo '<div>
<table>
		<tr>
		<th>Nahled</th>
			<th>Name</th>
			<th>Velikost</th>
			<th>Typ</th>
			<th>Rozmery Sirka X Vyska</th>
			<th>Smazat</th>
			</tr>';
			
$dotaz='SELECT * FROM foto order by id asc';		
$vysledek=mysqli_query($conn, $dotaz);
while($zaznam=mysqli_fetch_array($vysledek)){

	if(isset($_POST['obr'.$zaznam['id']]) && $_POST['obr'.$zaznam['id']] == "on") {
		unlink('../foto/'.$zaznam['nazev']);
		unlink('../foto/mini/'.$zaznam['nazev']);

		$dotazMazani = 'DELETE FROM foto WHERE id = "'.$zaznam['id'].'"';
		$vysledekMazani = mysqli_query($conn, $dotazMazani);

		if($vysledekMazani) {
			echo '<div id="ok">Obrazek '.$zaznam['nazev'].' byl smazan.</div>';
		} else {
			echo '<div id="err">Obrazek '.$zaznam['nazev'].' nebyl smazan.</div>';
		}
	} else {			
		$imageName = $zaznam['nazev'];
		list($width, $height, $type, $attr) = getimagesize("../foto/$imageName");
		switch($type) {
			case 1:
				$imageType = 'GIF';
				break;
			case 2:
				$imageType = 'JPG / JPEG';
				break;
			case 3:
				$imageType = 'PNG';
				break;
			default:
				die('Formát neznamy.');
		}
				
		$imageSize = filesize("../foto/$imageName");
		if($imageSize > 1024) {
			// vyplati se prepocitat velikost na kB?
			$imageSize = $imageSize / 1024;
			
			if($imageSize > 1024) {
				// pokud ma smysl prepociate velikost na MB
				$imageSize = $imageSize / 1024;
				// vysledek zaokrouhlime
				$imageSize = round($imageSize, 2) .' MB';
			} else {
				// zaukrouhleni pro kB
				$imageSize = round($imageSize) .' kB';
			}
		} else {
			// zaokrouhleni neni potreba, prvni podminka nebyla splnena, proto jsme prvni hodnotu nedelili
			$imageSize = round($imageSize) .' B';
		}

		$imageWidth = $width;
		$imageHeight = $height;
		
		
		echo '<tr><td><a href="../foto/'.$zaznam['nazev'].'" target=_blank"><img src="../foto/mini/'.$zaznam['nazev'].'" /></a></td>
				<td>'.$zaznam['nazev'].'</td>	
				<td>'.$imageSize.'</td>	
				<td>'.$imageType.'</td>
				<td>'.$imageWidth.' px X '.$imageHeight.' px</td>
				<td><input type="checkbox" name="obr'.$zaznam['id'].'"</td></tr>';
	}
}

echo '</table></div>';	

echo '<input type="submit" value="smazat oznacene obrazky"/>';
echo '</form>';

echo '<br><br><br><br><br><a href="index.php">Zpet do Dashboard</a>';
?>
