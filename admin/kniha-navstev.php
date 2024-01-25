<?php
if(isset($volej)!="ano"){
	echo 'Musíte se přihlásit.';
	die();
}

require "../pripojeni.php";

if(!isset($_GET['id'])) {$_GET['id'] = null;}

if(is_numeric($_GET['id'])){
	if(trim(isset($_POST['jmeno']) != "" && trim($_POST['prispevek']) !="" )){
		$jmeno=trim(htmlspecialchars(strip_tags($_POST['jmeno'])));
		$prispevek=trim(htmlspecialchars(strip_tags($_POST['prispevek'])));
		$dotaz="UPDATE knihanavstev SET jmeno='".$jmeno."', text='".$prispevek."' where id='".$_GET['id']."'";
		$vysledky=mysqli_query($conn, $dotaz);

		if($vysledky) {
			echo '<div id="ok">Příspěvek byl upravený.</div>';
		} else {
			echo '<div id="err">Příspěvek se nepodařilo upravit.</div>';
		}
	}

	$dotaz='SELECT * FROM knihanavstev WHERE id="'.$_GET['id'].'" ORDER BY cas DESC';
	$vysledek=mysqli_query($conn, $dotaz);
	$zaznam=mysqli_fetch_assoc($vysledek);
	?>

	<form action="" method="post" class="knihanavstev">
		<label for="jmeno">Jméno:</label><br>
        <input type="text" name="jmeno" id="jmeno"  class="vstup" value="<?php echo $zaznam['jmeno']; ?>" /><br>
		
        <label for="prispevek">Příspěvek:</label><br>
        <textarea name="prispevek" id="prispevek"  class="vstup"><?php echo $zaznam['text']; ?></textarea><br>
		<input type="submit" value="Uložit změny" />
	</form>

	<?php
} else { 
	echo 'Nejnovější a ještě nezkontrolované příspěvky:<br /><br /><form action="" method="post">';
	$dotaz='SELECT * FROM knihanavstev WHERE pokontrole="0" ORDER BY cas DESC';
	$vysledek=mysqli_query($conn, $dotaz);

	while($zaznam=mysqli_fetch_assoc($vysledek)) {
        
        if(!isset($_POST['ok'.$zaznam['id']])) {$_POST['ok'.$zaznam['id']] = "";}
        if(!isset($_POST['del'.$zaznam['id']])) {$_POST['del'.$zaznam['id']] = "";}

		if($_POST['ok'.$zaznam['id']]=="on"){
			$dotaz="UPDATE knihanavstev SET pokontrole='1' where id='".$zaznam['id']."'";
			mysqli_query($conn, $dotaz);
		} elseif($_POST['del'.$zaznam['id']]=="on"){
			$dotaz="DELETE FROM knihanavstev where id='".$zaznam['id']."'";
			mysqli_query($conn, $dotaz);
		} else {
			echo 'Přidal: '.$zaznam['jmeno'].' ('.date('d.m.Y',$zaznam['cas']).')
            <input type="checkbox" name="ok'.$zaznam['id'].'" /> příspěvek je v pořádku, 
			<input type="checkbox" name="del'.$zaznam['id'].'" /> smazat příspěvek, <a href="index.php?page=kniha&id='.$zaznam['id'].'">upravit</a>            
			<br>
			'.$zaznam['text'].'<br><br>';

		}
	};
	echo '<input type="submit" value="Aktualizovat" /></form>';

    echo '<br><br><br><br><br><a href="index.php">Zpet do Dashboard</a>';
}

?>