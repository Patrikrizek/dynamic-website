<?php 
session_start();
require "priprav-obsah.php"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title><?php echo $title; ?></title>
      <style type="text/css" media="all">@import "css/style.css";</style> 
      <link rel="shortcut icon" href="images/favicon.ico" />
      <meta name="robots" content="index,follow" />
      <meta name="description" content="<?php echo $metapopis; ?>" />
      <meta name="keywords" content="<?php echo $klicovaslova; ?>" />
   </head>
   <body>
      <div id="obalStranky">
         <div id="hlavicka">
            <div id="logo">
               <a href="index.php"><img src="obrazky/logo.png" /></a>
            </div>
            <div id="nadpisy">
            	<h1>Programování WWW stránek pro úplné začátečníky</h1>
                <h2>...a statické stránky se změní na dynamické</h2>
            </div>
         </div> 
         <div id="stred">
            <div id="levySloupec">
               <div id="menu">
                  <?php
                     $dotaz = 'SELECT * FROM texty WHERE zobrazvmenu="1" ORDER BY poradimenu ASC';
                     $vysledek = mysqli_query($conn, $dotaz);
                     $zaznam = mysqli_fetch_array($vysledek);                     
                     echo '<a href="index.php"><div class="menuLink">'.$zaznam['nazev'].'</div></a><br>';
                     while(isset($zaznam) !== "" && $zaznam=mysqli_fetch_array($vysledek)) {
                        echo '<a href="index.php?page='.$zaznam['urlnazev'].'"><div class="menuLink">'.$zaznam['nazev'].'</div></a><br>';
                     }
                  ?>
               </div>
            </div>
            <div id="obsah">
               <h3><?php echo $nazev; ?></h3>
               <p><?php echo $text; ?></p>
               <?php
                  //inport obsahu pouzitim if
                  // if(isset($_GET['page']) && $_GET['page'] == "kontakt") {
                  //    require "kontakt.php";
                  // }
                  // if(isset($_GET['page']) && $_GET['page'] == "fotogalerie") {
                  //    require "fotogalerie.php";
                  // }
                  // if(isset($_GET['page']) && $_GET['page'] == "kniha-navstev") {
                  //    require "kniha-navstev.php";
                  // }
                  
                  //inport obsahu pouzitim switch
                  // if(!isset($_GET['page'])) {$_GET['page'] = "";}

                  // switch($_GET['page']) {
                  //    case "kontakt":
                  //       require "kontakt.php";
                  //       break;

                  //    case "fotogalerie":
                  //       require "fotogalerie.php";
                  //       break;
                     
                  //    case "kniha-navstev":
                  //       require "kniha-navstev.php";
                  //       break;                   
                  // }

                  //inport obsahu dalsi zpusob
                  if(!isset($_GET['page'])) {$_GET['page'] = "";}
                  if($_GET['page'] == "kontakt" ||
                     $_GET['page'] == "fotogalerie" ||
                     $_GET['page'] == "kniha-navstev" ) {
                        require $_GET['page'].".php";
                  }
			      ?>
            </div>
            <div style="clear:both;"></div>
         </div> 
         <div id="paticka">
            Ukázka ke knize: <strong>Programování WWW stránek pro úplné začátečníky</strong>
         </div> 
      </div>
   </body>
</html>
