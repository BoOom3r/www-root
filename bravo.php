<?php
// Inclusion
require ("fonction.php");
// Demarrage de la session
session_start();
Init();
$date = date('d');
$filename = 'debug';
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
					Bravo <?php echo $_SESSION['username']; ?> ! Tu as répondu dans les 10 premiers :D</br>
					<br> Continue à rechercher des énigmes à travers le réseau pour gagner pleins de cadeaux !
				</p>
			</div>
		</div>
		<div class="crying">
			<img class="smiley" src="img/look.png">
		</div>
	</div>
<script>
window.setTimeout(function() {
    window.location = "<?php echo $date; ?>.php?uuid=<?php echo ($_SESSION['uuid']);?>";
  }, 7000);
</script>
</body>
</html>

