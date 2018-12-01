<?php
// Inclusion
require ("fonction.php");

// Demarrage de la session
session_start();
Init();
$datetriche = "date.txt";
if (file_exists($datetriche)) {
	$datefile = fopen('date.txt', 'r+');
	$reduit = fgets($datefile);
	fclose($datefile);
	$date = sprintf('%02d', date("d")-$reduit);
} else {
	$date = date("d");
}
$filename = 'debug';
$nomfichier = basename(__FILE__,'.php');
$uuid = $_SESSION['uuid'];
// Print player's head
$previous = sprintf('%02d', $nomfichier-1);
$next = sprintf('%02d', $nomfichier+1);

$monfichier = fopen('forum.txt', 'r+');
$_SESSION['forum'] = fgets($monfichier);
fclose($monfichier);


//mode debug ?
if (file_exists($filename)) {
	echo $_SESSION['uuid']."<br>";
	echo $_SESSION['ip']."<br>";
	echo $date."<br>";
	
}  

// Tests de tricheur
if ($date < $nomfichier){
	?><script>
	window.setTimeout(function() {
		window.location = "prison/tricheur.php?uuid=<?php echo ($_SESSION['uuid']);?>";
	  }, 1000);
	</script><?
} else {
	if (isset($_GET['uuid'])){


		
	//On récupère lenigme du jour
	// CONNEXION BDD ###########################
	$bdd = BddConnect();
	$req = $bdd->prepare('SELECT enigme FROM enigmes WHERE jour_avent = ? ');
	$req->execute(array($nomfichier));
	while ($donnees = $req->fetch()){
		$enigmedujour = $donnees['enigme'];
		 
	}
	$req->closeCursor();
	if(!empty($_POST)){
	// On verifie si le champ est rempli
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
	$req3->execute(array($_GET['uuid'], $nomfichier));
	while ($donnees3 = $req3->fetch()){
		$dejajoue = $donnees3['dejajoue'];
	if (file_exists($filename)) {
		echo ("nombre de participation : ".$dejajoue."<br>");
		}
		}
	$req->closeCursor();
	if ($dejajoue == 0){
		$repertoire = 'upload/'.$nomfichier.'/';    // Repertoire cible

		 
		// Tableaux de donnees
		$tabExt = array('png');    // Extensions autorisees
		$infosImg = array();
		 
		// Variables
		$extension = '';
		$message = '';
		$nomImage = '';
		
		
		if( !empty($_FILES['fichier']['name']) ){
		// Recuperation de l'extension du fichier
		$extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
		 // On verifie l'extension du fichier
		if(in_array(strtolower($extension),$tabExt)){
		  // On recupere les dimensions du fichier
		  $infosImg = getimagesize($_FILES['fichier']['tmp_name']);
	 
		  // On verifie le type de l'image
		  if($infosImg[2] >= 1 && $infosImg[2] <= 14){
			// On verifie les dimensions et taille de l'image
				  // Parcours du tableau d'erreurs
			  if(isset($_FILES['fichier']['error']) && UPLOAD_ERR_OK === $_FILES['fichier']['error']){
				// On renomme le fichier
			  $nomImage = $_GET['uuid'].'.'. $extension;
	 
				// Si c'est OK, on teste l'upload
				if(move_uploaded_file($_FILES['fichier']['tmp_name'], $repertoire.$nomImage)){
				    $message = 'Upload réussi ! Le staff va étudier ton screenshot !';		
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
					$req4->execute(array($_SESSION['username'], $_GET['uuid'], $nomfichier, $_SESSION['ip']));

					if (file_exists($filename)){
						echo ("Enregistré en base<br>");
					} 
				// test resolue 10  --------------------------
					// header('Location: bravo.php?uuid='.$_SESSION['uuid']);
									?><script>
						window.setTimeout(function() {
						window.location = "bravo.php?uuid="<?php echo $_SESSION['uuid'];?>;
						}, 0000);
						</script>
						<?php             
				} else {
              // Sinon on affiche une erreur systeme
              $message = 'Problème lors de l\'upload !';
            }
          } else {
            $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
          }
      } else {
        // Sinon erreur sur le type de l'image
        $message = 'Le fichier à uploader n\'est pas une image !';
      }
    } else {
      // Sinon on affiche une erreur pour l'extension
      $message = 'L\'extension du fichier est incorrecte !';
    }
  } else {
    // Sinon on affiche une erreur pour le champ vide
    $message = 'Veuillez remplir le formulaire svp !';
  }} else {
					 $message = 'Vous avez déja répondu !';
	}
				
	}		

	
		  
	   ?>
	<html>
	<head>
		<title>X-Mas Event 2018 - Onecraft</title>
		<meta charset="utf-8">
		<link href="style.css" rel="stylesheet">
	</head>
	<header class="header">

		<a href="http://www.onecraft.fr"><img class="logo" src="img/logoone.png"></a>
	</header>
	<body class="body">
		<div class="firstblock">
			<div id="subheader1">
				<div class="title">
				<p id="title">GRAND JEU DE NOËL</p>
				<p>Trouve les indices afin de résoudre la grande enigme de Onecraft ! Nous avons caché des indices à travers le réseau.<br><a href="<?php echo $_SESSION['forum'];?>" class="forum">Lien vers le post Forum</a></p>
				</div>
				<div class="who">
					<div class="welcome">
						<p>BONJOUR ET BIENVENUE<br><span id="name"><?php echo $_SESSION['username']; ?></span></p>
					</div>
				</div> 
			</div>
			<div class=enigme">
				<div class="headerenigme">
					<div class="numberenigme">
						<p>ENIGME N° <?php echo $nomfichier; ?></p>
					</div>
					<div class="bodybar1"></div>           
				</div>
				<div class="containenigme">
					<p><?php echo $enigmedujour; ?></p>
				</div>
			</div>
		</div>
    <div class="secondblock">
        <div class="headerreply">
		<?
		$req5 = $bdd->prepare('SELECT COUNT(UUID) AS dejajoue FROM indices WHERE UUID = ? AND NumeroIndice = ?');
		$req5->execute(array($_GET['uuid'], $nomfichier));
		while ($donnees5 = $req5->fetch()){
			$dejagagne = $donnees5['dejajoue'];
			}
		$req->closeCursor();
		if (file_exists($filename)) {
			echo ("nombre de participation : ".$dejajoue."<br>");
			}
		
		if ($dejagagne== 0){ ?>
                <div class="reply">
                    <p>VOTRE RÉPONSE</p>
                </div>
                <div class="bodybar2"></div>           
            </div>
				<p><span style="color: red;"><strong><? echo $message;?></strong></span></p>
				 <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']).'?uuid='.$_GET['uuid']; ?>" method="post">
		
				<label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Veuillez uploader votre screenshot : <br><br></label>
				<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
				<input type="hidden" id="uuid" name="uuid" value="<?php echo $_SESSION['uuid'];?>" />
				<input type="hidden" id="origine" name="origine" value="<?php echo $nomfichier;?>" />
				<input name="fichier" type="file" id="fichier_a_uploader" accept="image/png"/>
				<input type="submit" class="buttonreply" name="submit" value="Uploader" />
			  </p>
		</form>
	
 
		<? } else { 
		?>
		   <div class="reply">
                    <p>VOTRE RÉPONSE</p>
                </div>
                <div class="bodybar2"></div>           
            </div>
			<p> </p><p> </p>
		<p>Vous avez déja résolu cette enigme !</p>
		<p> </p>
		<?
		}?>
		   </div>
	</body>
	<footer>
		<div class="buttons">
			<a href="<?php echo $previous.".php?uuid=".$_SESSION['uuid'];?>"><div class="previous">
				<p class="textbuttons">ENIGME PRÉCÉDENTE</p>
			</div></a>
			<a href="<?php echo $next.".php?uuid=".$_SESSION['uuid'];?>"><div class="next">
				<p class="textbuttons">ENIGME SUIVANTE</p>
			</div></a>
		</div>
		<p class="copyright">Design by Alphao - Code by BoOm3r</p>
	</footer>
	</html>
	<?php

	} else {
?>

<html>
<head>
    <title>X-Mas Event 2018 - Onecraft</title>
    <meta charset="utf-8">
    <link href="style.css" rel="stylesheet">
</head>
<header class="header">

    <a href="http://www.onecraft.fr"><img class="logo" src="img/logoone.png"></a>
</header>
<body class="body">
    <div class="firstblock">
        <div id="subheader1">
            <div class="title">
            <p id="title">fais /indice en jeu pour commencer !</p>
</body></html>			
<?php
		
}} ?>