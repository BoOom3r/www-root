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
$date = date('d');
$filename = 'debug';
$nomfichier = basename(__FILE__,'.php');
$uuid = $_SESSION['uuid'];
// Print player's head
$previous = $nomfichier-1;
$next = $nomfichier+1;

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
            <p>Trouve les indices afin de résoudre la grande enigme de Onecraft ! Nous avons caché des indices à travers le réseau.<br><?php echo $_SESSION['forum'];?></p>
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
    </div>
</body>
<footer>
    <div class="buttons">
        <div class="previous">
            <a href="<?php echo $previous.".php?uuid=".$_SESSION['uuid'];?>"><p class="textbuttons">ENIGME PRÉCÉDENTE</p></a>
        </div>
        <div class="next">
            <p class="textbuttons"><a href="<?php echo $next.".php?uuid=".$_SESSION['uuid'];?>">ENIGME SUIVANTE</p></a>
        </div> 
    </div>
	<p class="copyright">Design by Alphao - Code by BoOm3r</p>
	<p><a href="test.php" class="secrect">test</p>
</footer>
</html>
<?php

	} else {
	echo ("Un problème est survenu. Veuillez fermer la page et recommencer");
	
}} ?>