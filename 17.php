<?php
// Inclusion
require ("fonction.php");

// Demarrage de la session
if (file_exists($filename)) {
	echo "start session";
}
session_start();
if (file_exists($filename)) {
	echo "init";
}
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
	echo $_SESSION['date']."<br>";
	
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
		
		$req6 = $bdd->prepare('SELECT * FROM lettredujour WHERE jouravent = ?');
			$req6->execute(array($nomfichier));
			while ($donnees6 = $req6->fetch()){
				$lettredujour = $donnees6['lettre'];
				}
			$req->closeCursor();
			if (file_exists($filename)) {
				echo ("Lettre : ".$lettredujour."<br>");
				}

		if ($dejagagne== 0){ ?>
                <div class="reply">
                    <p>VOTRE RÉPONSE</p>
                </div>
                <div class="bodybar2"></div>           
            </div>
			<form action="verifreponse.php" method="POST">
				<input type="hidden" id="uuid" name="uuid" value="<?php echo $_SESSION['uuid'];?>" />
				<input type="hidden" id="origine" name="origine" value="<?php echo $nomfichier;?>" />
				<input type="text" name="reponse" id="reponse" class="inputreply">
				<input id="envoyer" class="buttonreply" type="submit" />
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
		<? if ($lettredujour != "") { ?><p>Voici la lettre du jour : <strong><span style="color: red;"><?php echo $lettredujour; ?></span></strong></p>
		<?}
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