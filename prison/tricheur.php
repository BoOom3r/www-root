<?php
// Inclusion
require ("../fonction.php");
// Demarrage de la session
session_start();
Init();
$date = date('d');
$filename = '../debug';

$bdd = BddConnect();
	
$req4 = $bdd->prepare('INSERT INTO logger (UUID, ip, pseudo, motif) VALUES (?, ?, ?, ?)');
$req4->execute(array($_SESSION['uuid'], $_SESSION['ip'], $_SESSION['username'], "Essaye de lire l'avenir"));
if (file_exists($filename)){
	echo ("Enregistré en base le tricheur<br>");
} 

?>


<p>&nbsp;</p>
<p><a href="http://www.onecraft.fr"><img src="https://www.onecraft.fr/forum/styles/uix/uix/logo.png" alt="" width="308" height="80" /></a></p>
<h1>&nbsp;</h1>
<p><h1 style="text-align: left; padding-left: 10%;"><img src="https://cdn.discordapp.com/attachments/514156788258701312/514159971655745536/u-mad-bro-14999203.png"  width="308"/></h1>
<p>&nbsp;</p>
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<script> 
window.setTimeout(function() {
    window.location = 'tricheur2.php';
  }, 4000);
</script>