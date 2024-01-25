<?php
if(isset($volej)!="ano"){
	echo 'Musíte se přihlásit.';
	die();
}


require "../pripojeni.php";
if(!isset($_POST['publikovan'])) {
	$_POST['publikovan'] = "";
}
if(!isset($_POST['zobrazvmenu'])) {
	$_POST['zobrazvmenu'] = "";
}
if(isset($_POST["nazev"])){
	$nazev=$_POST["nazev"];
	$urlnazev=$_POST['urlnazev'];
	$text=$_POST['text'];
	$slova=$_POST['slova'];
	$metapopis=$_POST['metapopis'];
	$publikovan=$_POST['publikovan'];
	$zobrazvmenu=$_POST['zobrazvmenu'];
	$poradimenu=$_POST['poradimenu'];
}
if(isset($_POST["nazev"]) && $_GET['id']!="new") {
	$dotaz="UPDATE texty SET
				nazev='".$nazev."',
				urlnazev='".$urlnazev."',
				text='".$text."',
				klicovaslova='".$slova."',
				metapopis='".$metapopis."',
				publikovan='".$publikovan."',
				zobrazvmenu='".$zobrazvmenu."',
				poradimenu='".$poradimenu."'
				WHERE idtextu='".$_GET['id']."'";
				
				if(mysqli_query($conn, $dotaz)) {
					echo '<div id="ok">Změny byli úspešne uloženy do databáze.</div>';
				} else {
					echo '<div id="err">Nepodařilo se uložit změny do databáze!</div>';
				}
			}
			if(isset($_POST["nazev"]) && $_GET['id']=="new") {
				$dotaz = 'INSERT INTO texty (nazev, text, urlnazev, klicovaslova, metapopis, publikovan, zobrazvmenu, poradimenu)
	VALUES ("'. $nazev. '", "'. $text. '",  "'. $urlnazev. '", "'. $slova. '", "'. $metapopis. '", "'. $publikovan. '", "'. $zobrazvmenu. '", "'. $poradimenu.'")';
    $vysledky = mysqli_query($conn, $dotaz) or die(mysqli_error($db));
	if($vysledky) {
		echo '<div id="ok">Text byl úspěšně přidán do databáze.</div>';
	} else {
		echo '<div id="err">Text sa nepodařilo přidat do databáze.</div>';
	}
	echo '<html><meta http-equiv="REFRESH" content="2;index.php?page=texty"></html>'; die();
}
if($_GET['id']!="new"){
	$dotaz='SELECT * FROM texty WHERE idtextu="'.$_GET['id'].'"';		
	$vysledek=mysqli_query($conn, $dotaz);
	$zaznam=mysqli_fetch_array($vysledek);
};

?>

<form id="clanok" name="clanok" method="post" action="">
	<label for="nazev">Název textu:</label>
	<input type="text" class="vstup" name="nazev" id="nazev" value="<?php if(!isset($zaznam['nazev'])) {echo $zaznam['nazev'] = "";} else {echo $zaznam['nazev'];}; ?>" /> <br>
	<label for="urlnazev">URLnázev:</label>
	<input type="text" class="vstup" name="urlnazev" id="urlnazev" value="<?php if(!isset($zaznam['urlnazev'])) {echo $zaznam['urlnazev'] = "";} else {echo $zaznam['urlnazev'];}; ?>" /><br>
	<label for="text">Text:</label>
	<textarea name="text" class="vstup" id="text" rows="10" ><?php if(!isset($zaznam['text'])) {echo $zaznam['text'] = "";} else {echo $zaznam['text'];}; ?></textarea><br>
	<label for="slova">Klíčová slova:</label>
	<input type="text" class="vstup" name="slova" id="slova" value="<?php if(!isset($zaznam['klicovaslova'])) {echo $zaznam['klicovaslova'] = "";} else {echo $zaznam['klicovaslova'];}; ?>" /><br>
	<label for="metapopis">Metapopis:</label>
	<textarea name="metapopis" class="vstup" rows="3" id="metapopis" ><?php if(!isset($zaznam['metapopis'])) {echo $zaznam['metapopis'] = "";} else {echo $zaznam['metapopis'];}; ?></textarea><br>
	<label for="publikovan">Publikovat?</label>
	<input type="checkbox" name="publikovan" id="publikovan" <?php if(!isset($zaznam['publikovan']) && $zaznam['publikovan'] = "0") {echo 'value="0"';} else {echo 'value="1"';}; if($zaznam['publikovan'] == "1") {echo 'checked';}?>/><br>
	<label for="zobrazvmenu">Menu?</label>
	<input type="checkbox" name="zobrazvmenu" id="zobrazvmenu" <?php if(!isset($zaznam['zobrazvmenu']) && $zaznam['zobrazvmenu'] = "0") {echo 'value="0"';} else {echo 'value="1"';}; if($zaznam['zobrazvmenu'] == "1") {echo 'checked';} ?>/><br>
<label for="poradimenu">Poradit v menu:</label>
	<input type="number" name="poradimenu" id="poradimenu" step="1" min="0" class="vstup" value="<?php if(!isset($zaznam['poradimenu'])) {echo $zaznam['poradimenu'] = "";} else {echo $zaznam['poradimenu'];}; ?>"><br>
<input type="submit" value="Uložit změny"><br>
</form><br><br><br><br>

<a href="index.php?page=texty">Zpet do Seznamu textu</a>
