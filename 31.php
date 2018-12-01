<?php
require ("config.php.ini");
require ("fonction.php"); 
// Demarrage de la session
session_start();
Init();
$date = date('d');
$filename = 'debug';
if (isset ($_GET['uuid'])){
	$uuid = $_GET['uuid'];
	
$bdd = BddConnect();
	
$req4 = $bdd->prepare('INSERT INTO logger (UUID, ip, pseudo, motif) VALUES (?, ?, ?, ?)');
$req4->execute(array($_GET['uuid'], $_SESSION['ip'], $_SESSION['username'], "Crois encore au père Noel"));
if (file_exists($filename)){
	echo ("Enregistré en base le tricheur<br>");
} 

?>
<p>&nbsp;</p>
<p><img src="https://www.onecraft.fr/forum/styles/uix/uix/logo.png" alt="" width="308" height="80" /></p>
<h1>&nbsp;</h1>
<h1 style="text-align: left; padding-left: 30%;"><span style="color: #333333;"><strong>PTDRRRRR !!! T'as cru que Noël c'était toute l'année ???<br> Allez, la bonne année !! </strong></span></h1>
<h1>&nbsp;</h1>
<h1>&nbsp;</h1>
<p style="text-align: left; padding-left: 30%;"><img src="/img/risitas.gif" alt="" /></p>
<h1>&nbsp;</h1>
<script>
window.setTimeout(function() {
    window.location = "index.php?uuid=<?php echo ($_SESSION['uuid']);?>";
  }, 7000);
</script>
<?php
} else {
	?><script>
window.setTimeout(function() {
    window.location = "http://onecraft.fr";
  }, 0000);
</script>
<?
}
?>