<?php
if (!isset($_GET['uuid'])){	
?>	<html>
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
            <p id="title">Bonjour et bienvenue. Connecte-toi à play.onecraft.fr et saisi la commande <strong>/indice</strong> en jeu pour commencer !</p>
</body></html><?php
} else {
	
$datetriche = "date.txt";
if (file_exists($datetriche)) {
$datefile = fopen('date.txt', 'r+');
$reduit = fgets($datefile);
fclose($datefile);
$date = sprintf('%02d', date("d")-$reduit);
} else {
	$date = date("d");
}
	// $datetmp = date('d');
	// $date = $datetmp - 18
	

	$urlJ = $date.'.php?uuid='.$_GET['uuid'];
?>
	<script>
	window.setTimeout(function() {
		window.location = '<?php echo $urlJ;?>';
	  }, 4000);
	</script>
	<p>&nbsp;</p>
	<p><a href="http://www.onecraft.fr"><img src="https://www.onecraft.fr/forum/styles/uix/uix/logo.png" alt="" width="308" height="80" /></a></p>
	<h1>&nbsp;</h1>
	<h1 style="text-align: left; padding-left: 10%;"><span style="color: #333333;"><strong>Grand jeu de No&euml;l</strong></span></h1>
	<p>&nbsp;</p>
	<p style="text-align: left; padding-left: 20%;"><span style="color: #333333;"><strong>Trouvez les indices afin de r&eacute;soudre la grande enigme de Onecraft ! Nous avons cach&eacute;, &agrave; des indices à travers le r&eacute;seau.</strong></span></p>
	<p style="text-align: left; padding-left: 20%;"><span style="color: #333333;"><strong></strong></span></p>
	<p style="text-align: left; padding-left: 20%;">&nbsp;</p>
	<p>&nbsp;</p>
<?php 
} 
?>