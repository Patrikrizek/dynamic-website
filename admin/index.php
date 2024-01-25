<?php
session_start();

if(!isset($_SESSION['prihlasen']) && isset($_POST['login'])!="") {
		require "../pripojeni.php";
		$dotaz='SELECT * FROM admini WHERE login="'.$_POST['login'].'" AND heslo="'.hash('sha1',$_POST['heslo']."fk8e53g710wr9").'"';
		$vysledek=mysqli_query($conn, $dotaz);
	    $zaznam=mysqli_fetch_array($vysledek);
	    if(isset($zaznam['id'])!=""){
			$_SESSION['prihlasen']=$zaznam['id'];
		}
};
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>Administrační zóna</title>
      <style type="text/css" media="all">@import "style.css";</style> 
      <link rel="shortcut icon" href="images/favicon.ico" />
      <meta name="robots" content="noindex,nofollow" />
   </head>
   <body>
   <?php

	if(!isset($_SESSION['prihlasen']) || !is_numeric($_SESSION['prihlasen'])) {
		require "login.php";
	} else {
		$volej="ano";
	  	require "admin.php"; 
	};
   ?>
   </body>
</html>
