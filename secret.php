<?php
// Inclusion
require ("fonction.php");
// Demarrage de la session
session_start();
Init();
$date = date('d');
$filename = 'debug';

if (isset ($_GET['uuid']) && isset($_GET['trouve'])){
	if ($_GET['trouve'] = "oui") {
	header('Location: 19.php?uuid='.$_SESSION['uuid'].'&reponse=mineponie');
}} else {
	header('Location: 19.php?uuid='.$_SESSION['uuid']);
}

?>

<html>
<head>
	<title>Bravo !!!</title>
	<meta charset="utf-8">
	<link href="style.css" rel="stylesheet">
</head>
<body class="body">
	<header class="header">
		<a href="htpp://www.onecraft.fr">
			<img class="logo" src="img/logoone.png">
		</a>
	</header>
	<div class="firstblock">
		<div id="subheader1">
			<div class="title">
				<p id="title">
					Bravo <?php echo $_SESSION['username']; ?> ! la réponse est </br>
					<br> Mineponie
				</p>
			</div>
		</div>
		<div class="crying">
			<img class="smiley" src="img/look.png">
		</div>
	</div>
<script>
window.setTimeout(function() {
    window.location = "19.php?uuid=<?php echo ($_SESSION['uuid']);?>";
  }, 7000);
</script>
</body>
</html>

