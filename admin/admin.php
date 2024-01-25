<?php
if(isset($volej)!="ano"){
	echo 'Musíte se přihlásit.';
	die();
}
?>

<div id="menu">
		<a href="odhlas.php">Odhlásit se</a> | 
		<a href="index.php?page=texty">Seznam textů</a> | 
		<a href="index.php?page=foto">Fotogalerie</a> |
		<a href="index.php?page=heslo">Zmena hesla</a> |
		<a href="index.php?page=kniha">Kniha navstev</a> |</div> 
<div id="obsah">

<?php 
if(!isset($_GET['page'])) {
	$_GET['page'] = "";
}

switch ($_GET['page']) {
	case 'texty':
		if(!isset($_GET['id'])){
			require "seznam.php"; 
		} else {
			require "edit-text.php";
		}
		break;
	case 'foto':
		require "fotogalerie.php";
		break;
	case 'heslo':
		require "nove-heslo.php";
		break;
	case 'kniha':
			if(!isset($_GET['id'])){
				require "kniha-navstev.php"; 
			} else {
				require "kniha-navstev.php"; 
			}
		break;
	default:
		echo
		'<h1>Dashboard</h1>
		<h2>Ahoj Admin!</h2>
		<span>Toto je daschboard pro administratora:</span>
		<ul>
			<li>Pro vyber textu, prejdete do <a href="index.php?page=texty">Seznam textů</a> v hornim panelu.</li>
			<li>Pro validaci nove vlozenych komentaru, prejdete do <a href="index.php?page=kniha">Kniha navstev</a>.</li>
		</ul>';
		break;
}
?>
</div>