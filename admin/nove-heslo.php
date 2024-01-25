<?php
if(!isset($_SESSION)) { 
	 session_start(); 
}

if(isset($volej) !="ano") {
    echo 'Musite se prihlasit.';
    die();
}

if(isset($_POST['nove']) !="") {
    if($_POST['nove'] != $_POST['nove2']) {
        echo '<div id="err">Nove heslo a jeho kontrola se neshoduji.</div>';
    } elseif(strlen($_POST['nove2']) < 6) {
        echo '<div id="err">Nove heslo je prilis kratke</div>';
    } else {
        require "../pripojeni.php";
        $dotaz = 'SELECT * FROM admini WHERE id = "'.$_SESSION['prihlasen'].'"';
        $vysledek = mysqli_query($conn, $dotaz);
        $zaznam = mysqli_fetch_array($vysledek);
        if(hash('sha1',$_POST['stare']) != $zaznam['heslo']) {
            echo '<div id="err">Nespravne uvedene aktualni heslo.</div>';
        } else {
            $dotaz = 'UPDATE admini SET heslo = "'.hash('sha1',$_POST['nove']."fk8e53g710wr9").'" WHERE id = "'.$_SESSION['prihlasen'].'"';
            if(mysqli_query($conn, $dotaz)) {
                echo '<div id="ok">Heslo bylo uspesne zmeneno.</div>';
            } else {
                echo '<div id="err">Heslo se nepodarilo zmenit.</div>';
            }
        }
    }
}
?>

<br>
<form action="" method="post">
    <label for="stare">Aktualni heslo:</label>
        <input type="password" name="stare" id="stare"><br>
    <label for="nove">Nove heslo:*</label>
        <input type="password" name="nove" id="nove"><br>
    <label for="nove2">Nove znovu:</label>
        <input type="password" name="nove2" id="nove2"><br>
    <input type="submit" value="Zmenit heslo">        
</form>
<small>*Nove heslo se nesmi shodovat se starym a musi byt delsi nez 6 znaku.</small><br><br><br><br><br><br>

<a href="index.php">Zpet do Dashboard</a>