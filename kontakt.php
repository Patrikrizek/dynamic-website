<?php
$jmeno = $telefon = $email = $predmet = $zprava = '';

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$jmeno=trim(htmlspecialchars(strip_tags($_POST['jmeno'])));
	$telefon=trim(htmlspecialchars(strip_tags($_POST['telefon'])));
	$email=trim(htmlspecialchars(strip_tags($_POST['email'])));
	$predmet=trim(htmlspecialchars(strip_tags($_POST['predmet'])));
	$zprava=trim(htmlspecialchars(strip_tags($_POST['zprava'])));
}


if(isset($_POST['poslat'])=="ano") {
		$chyby=array();
		if(empty($jmeno)) { $chyby[]='Vyplňte své jméno.'; };  // $jmeno je prázdné
		if(is_numeric($jmeno)) { $chyby[]='Jméno nemůže mít číselnou hodnotu.'; };  // jméno nemůže být číslo
		if(strlen($jmeno)<=2) { $chyby[]='Uvedené jméno je moc krátke.'; };  // minimální délka jména je dva znaky
		
		if(empty($telefon) && empty($email)){  // pokud jsou oba údaje nevyplněny
			$chyby[]='Uveďte kontaktní telefon nebo emailovou adresu.'; 
		};
		if(!empty($telefon)) {  // pokud je $telefon vyplněn
			$telefon=str_replace('+', '', $telefon);   // zmažeme nečíselné znaky 
			$telefon=str_replace('-', '', $telefon);
			$telefon=str_replace('/', '', $telefon);
			$telefon=str_replace(' ', '', $telefon);   // zmažeme i mezery
			if(!is_numeric($telefon)) {  // pokud to není číslo, obsahuje nepovolené znaky
				$chyby[]='Telefonní kontakt obsahuje nepovolené znaky.';
			}
			if(strlen($telefon)<9 || strlen($telefon)>15) {
				// délku si můžete zvolit sami podle vašeho uvážení
				$chyby[]='Telefonní kontakt má nesprávnou délku.';
			}
		}
		if(!empty($email)){  // pokud je vyplněný $email
			if(!preg_match('/^[^@]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}+$/', $email)){
				// emailová adresa nemá správní tvar
				$chyby[]='Uvedená emailová adresa nemá správní tvar.';
			}
		}
		
		if(empty($predmet)){ $chyby[]='Uveďte předmět vaši zprávy.'; };
		if(strlen($predmet)<5){ $chyby[]='Předmět zprávy je příliš krátký.'; };
		if(empty($zprava)){ $chyby[]='Napište vaši zprávu.'; };
		if(strlen($zprava)<20){ $chyby[]='Zpráva je příliš krátká. Zkuste ji popsat podrobněji.'; };
		
		if($_POST['kontrola'] != $_SESSION['captcha']) {
			$chyby[] = 'Kontrolni cislo se neshoduje. Zkuste to znovu.'; 
		}
		
		$chyba=join('<br />', $chyby);
		if(!empty($chyba)){
			echo '<div class=“chybovaHlaska“>'.$chyba.'</div>';
		};
		if(empty($chyba)){    // všechna jsou v pořádku
			$textZpravy='Odesílatel: <strong>'.$jmeno.'</strong><br /><br />
			[ '.$email.' '.$telefon.' ]<br /><br />
			'.$zprava;
			
			require "class.phpmailer.php";
			require "class.smtp.php";
			
			$Mail = new PHPMailer();
			$Mail->CharSet = 'UTF-8';
			
		    $Mail->IsSMTP();
			$Mail->Host = "smtp.googlemail.com";
			$Mail->Username="prihlasovaci.jmeno.k.emailu";
			$Mail->Password="heslo";
			$Mail->SMTPAuth=true;
			$Mail->From = "prihlasovaci.jmeno.k.emailu@gmail.com";
			$Mail->FromName = $jmeno;
			$Mail->AddAddress("prihlasovaci.jmeno.k.emailu@gmail.com");
			if(isset($_POST['kopie'])=="on") {
				$Mail->AddBCC($email);
			}
			$Mail->IsHTML(true);
		    $Mail->Subject  = $predmet;
		    $Mail->Body = $textZpravy;
			$cistyText=strip_tags($textZpravy);
			$Mail->AltBody=$cistyText;
			
			if($Mail->Send()) {
				$okHlaska="Zpráva byla úspěšne odesláná.";
			} else {
				echo "Zprávu se nepodařilo odeslat. Zkuste to znovu.";
			}
		}
	}
	
	
	if(isset($okHlaska) == ""){
		echo '<form action="" method="post">
		<label for="jmeno">Vaše jméno:</label>
		<input type="text" name="jmeno" id="jmeno" value="'.$jmeno.'"/><br />
		<label for="telefon">Telefon:</label>
		<input type="text" name="telefon" id="telefon" value="'.$telefon.'" /><br />
		<label for="email">Email:</label>
		<input type="text" name="email" id="email" value="'.$email.'" /><br />
		<label for="predmet">Předmět:</label>
		<input type="text" name="predmet" id="predmet" value="'.$predmet.'" /><br />
		<label for="zprava">Zpráva / dotaz:</label>
		<textarea name="zprava" id="zprava" rows="3">'.$zprava.'</textarea><br />

		<label for="kontrola">Kontrola:</label>
		<img src="captcha/captcha.php">
		<input type="text" name="kontrola" id="kontrola"  minmaxlength="0" maxlength="3" class="kontaktInput" style="width: 40px;" value=""><br>

		<input type="checkbox" name="kopie" id="kopie"';
		if(isset($_POST['kopie']) == "on"){ echo ' checked="checked"'; }; 
		echo '/><label for="kopie" style="width:350px;">zaslat kopii zprávy na můj 
		email</label><br />
		<input type="submit" value="Odeslat dotaz" />
		<input type="hidden" name="poslat" value="ano" />
		</form>'; 
	} else {
		echo $okHlaska;
	}
?>
