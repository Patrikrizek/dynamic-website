<?php
//vkladani prispevku do DB
if(trim(isset($_POST['jmeno']) != "" && trim($_POST['prispevek']) !="" )) {
    $jmeno = trim(htmlspecialchars(strip_tags($_POST['jmeno'])));
    $prispevek = trim(htmlspecialchars(strip_tags($_POST['prispevek'])));

    $dotaz = 'INSERT INTO knihanavstev (jmeno, text, cas, zobrazovat) VALUES ("'.$jmeno.'", "'.$prispevek.'", "'.time().'", "1")';
    $vysledky = mysqli_query($conn, $dotaz) or die(mysqli_error($conn));

    if($vysledky) {
        echo '<div id="ok">Prispevek byl uspesne vlozen.</div>';
    } else {
        echo '<div id="err">Prispevek se nezdarilo vlozit.</div>';
    }
}

//strankovani
$pocet = 3;
if(isset($_GET['strana']) > 0 && is_numeric($_GET['strana'])) {
    $od = $_GET['strana'] * $pocet;
} else {
    $od = 0;
}

//zobrazovani prispevku
$dotaz = 'SELECT * FROM knihanavstev WHERE zobrazovat = "1" ORDER BY cas DESC limit '.$od.', '.$pocet;
$vysledek = mysqli_query($conn, $dotaz);
while($zaznam = mysqli_fetch_assoc($vysledek)) {
    echo '  <div class="prispevek">
                <div class="horniRadek">
                    <div class="pridal">
                        Pridal(a):<strong>'.$zaznam['jmeno'].'</strong>
                    </div>
                    <div class="datum">
                        '.date('d.m.Y',$zaznam['cas']).'
                    </div>
                </div>
                <div class="textPrispevku">
                    '.$zaznam['text'].'
                </div>
            </div>';
}

//zobrazovani strankovani
echo'<div class="strankovani">';

$dotaz = 'SELECT * FROM knihanavstev WHERE zobrazovat = "1"';
$vysledek = mysqli_query($conn, $dotaz);
$prispevku = mysqli_num_rows($vysledek);

$i = 0;
while($prispevku>0) {
    $str = $i + 1;

    if($i == $od/$pocet) {
        echo '<strong>'.$str.'</strong>'.' ';
    } else {
        echo '<a href="index.php?page=kniha-navstev&strana='.$i.'">'.$str.'</a>'.' ';
    }

    $prispevku = $prispevku-$pocet;
    $i++;
}

echo '</div>';

//zobazovani prispevkoveho formulare
?>

<form action="" method="post" class="knihanavstev">
    Pridejte taky Vasi zkusenost!<br><br>
    <label for="jmeno">Jmeno:</label><br>
    <input type="text" name="jmeno" id="jmeno" class="kontaktiInput"><br>
    <label for="prispevek">Prispevek:</label><br>
    <textarea name="prispevek" id="prispevek" class="kontaktInput"></textarea><br>
    <input type="submit" value="Pridat prispevek">
</form>