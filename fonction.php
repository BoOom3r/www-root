<?php 
require ("mojang-api.class.php");


// Demarrage de la session
function Init(){
	$_SESSION['uuid'] = $_GET['uuid'];
	$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['date'] = date('d');
	$_SESSION['avatar'] = '<img src="' . MojangAPI::embedImage(MojangAPI::getPlayerHead($_SESSION['uuid'])) . ' " width="70"/>';
	$_SESSION['username'] = MojangAPI::getUsername($_SESSION['uuid']);
	$_SESSION['debug'] = 'debug';
	 	
}

function BddConnect(){
	$dbname = "Onecraft";
	$dbhost = "192.168.10.30";
	$dbport = "3308";
	$dbuser = "OnecraftNoelEvent";
	$dbpass = "0n3cr4ftN0elEvent";
	$filename = 'debug';
	
	try{
	$bdd = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$dbname.';charset=utf8', $dbuser, $dbpass);
// Debug \\\\\\\\\\\\\\\\\\\\\\\
	if (file_exists($filename)) {
		echo ("tentative de connexionBDD<br>");
	} 
	return $bdd;
}
catch(Exception $e){
	die('Erreur : '.$e->getMessage());
}
	
}
?>