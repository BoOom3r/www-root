<?php 
session_start();
// Inclusion
require ("fonction.php");
require ("config.php.ini");
$filename = 'debug';

if (file_exists($filename)){
	if (isset($_POST['reponse'])){
		echo $_POST['reponse'];
	}
		if (isset($_POST['uuid'])){
		echo $_POST['uuid'];
	}
		if (isset($_POST['origine'])){
		echo $_POST['origine'];
	}
} 

if (isset($_POST['reponse']) AND isset($_POST['uuid']) AND isset($_POST['origine'])){
	
	$reponsedonnee = $_POST['reponse']; 
	$useruuid = $_POST['uuid'];
	$origine = $_POST['origine'];
// Debug \\\\\\\\\\\\\\\\\\\\\\\
	if (file_exists($filename)) {
		echo "$reponsedonnee<br>";
		echo "$useruuid<br>";
		echo "$origine<br>";
	} 
// Debug \\\\\\\\\\\\\\\\\\\\\\\
	if (file_exists($filename)) {
		echo $_SESSION['uuid']."<br>";
		echo $_SESSION['ip']."<br>";	
	} 	
// CONNEXION BDD ###########################
$bdd = BddConnect();
// Debug \\\\\\\\\\\\\\\\\\\\\\\
	if (file_exists($filename)) {
		echo ("connexion réussie <br>");
	}
// Debug \\\\\\\\\\\\\\\\\\\\\\\
	if (file_exists($filename)) {
		if (isset ($e)){
			echo "$e <br>";
	}}

// cherche dans la bdd la reponse du jour --------------------------
	$req = $bdd->prepare('SELECT reponse FROM enigmes WHERE jour_avent = ? ');
	$req->execute(array($_POST['origine']));
	while ($donnees = $req->fetch()){
		$reponsebdd = $donnees['reponse'];
		//	mode debug ?
		if (file_exists($filename)) {
			echo ("$reponsebdd<br>");
		} 
	}
	$req->closeCursor();
// verification de la réponse --------------------------
	if (file_exists($filename)) {
		echo ("Verification de la reponse <br>");
	}
	if (isset ($reponsebdd)){
		if (strcasecmp($reponsebdd, $_POST['reponse']) == 0) {
			$req = $bdd->prepare('SELECT resolu FROM enigmes WHERE jour_avent = ? ');
			$req->execute(array($_POST['origine']));
			while ($donnees = $req->fetch()){
					if (file_exists($filename)) {
			echo ("nombre resolu : ".$donnees['resolu']." <br>");
				}
			$compteuractuel = $donnees['resolu'];
			$req->closeCursor();
			}
	
			if (file_exists($filename)) {
				echo ("est ce que resolu<br>");
			}
		
// test si uuid deja joué ojd --------------------------
			$req3 = $bdd->prepare('SELECT COUNT(UUID) AS dejajoue FROM indices WHERE UUID = ? AND NumeroIndice = ?');
			$req3->execute(array($useruuid, $_POST['origine']));
			while ($donnees3 = $req3->fetch()){
				$dejajoue = $donnees3['dejajoue'];
			if (file_exists($filename)) {
				echo ("nombre de participation : ".$dejajoue."<br>");
				}
				}
			$req->closeCursor();
			if (file_exists($filename)) {
				echo ("nombre de participation : ".$dejajoue."<br>");
				}
			if ($dejajoue == 0){
				if (file_exists($filename)){
					echo ("pas repondu<br>");
				} 
				
				$compteurfutur = $compteuractuel+1;
				if (file_exists($filename)){
					echo ("nombre resolu : ".$compteurfutur);
				} 
				$req2 = $bdd->prepare('UPDATE enigmes SET resolu = ? WHERE jour_avent = ? ');
				$req2->execute(array($compteurfutur, $_POST['origine']));
				if (file_exists($filename)){
					echo ("Enregistré en base<br>");
					echo ($_SESSION['ip']."<br>");
				} 
				$req4 = $bdd->prepare('INSERT INTO indices (Pseudo, UUID, NumeroIndice, IP) VALUES (?, ?, ?, ?)');
				$req4->execute(array($_SESSION['username'], $useruuid, $origine, $_SESSION['ip']));
	
				if (file_exists($filename)){
					echo ("Enregistré en base<br>");
				} 
// test resolue 10  --------------------------
				if ($compteuractuel > 9){
					header('Location: toolate.php?uuid='.$_SESSION['uuid']);
					echo "dejajoue";
/*					?><script>
					window.setTimeout(function() {
					window.location = "toolate.php?uuid="<?php echo $_SESSION['uuid'];?>";
					}, 0000);
					</script>
					<?php                                    */
				} else { 
				
					header('Location: bravo.php?uuid='.$_SESSION['uuid']);
					echo "dejajoue";
/*					?><script>
					window.setTimeout(function() {
					window.location = "bravo.php?uuid="<?php echo $_SESSION['uuid'];?>;
					}, 0000);
					</script>
					<?php             */
			} 
		}else {
				header('Location: dejajoue.php');
			}
						
		}		
	 else {
		?><script>
		window.setTimeout(function() {
		window.location = "perdu.php?uuid=<?php echo $_SESSION['uuid'];?>";
		}, 0000);
		</script>
		<?php
	}
}
}
	else {
	?><script>
window.setTimeout(function() {
    window.location = "index.php?uuid=<?php echo $_SESSION['uuid'];?>";
  }, 0000);
</script><?php
}

?>