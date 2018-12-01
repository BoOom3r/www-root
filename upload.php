<?php
// Constantes
define('TARGET', '06/');    // Repertoire cible
define('MAX_SIZE', 50000);    // Taille max en octets du fichier
define('WIDTH_MAX', 1920);    // Largeur max de l'image en pixels
define('HEIGHT_MAX', 720);    // Hauteur max de l'image en pixels
 
// Tableaux de donnees
$tabExt = array('png');    // Extensions autorisees
$infosImg = array();
 
// Variables
$extension = '';
$message = '';
$nomImage = '';
$date = date('d');
$origine = $_POST['origine'];

 
/************************************************************
 * Creation du repertoire cible si inexistant
 *************************************************************/
if( !is_dir(TARGET) ) {
  if( !mkdir(TARGET, 0755)) {
    exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
  }
}
 
/************************************************************
 * Script d'upload
 *************************************************************/
if(!empty($_POST)){
  if( !empty($_FILES['fichier']['name'])){
    // Recuperation de l'extension du fichier
    $extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
    // On verifie l'extension du fichier
    if(in_array(strtolower($extension),$tabExt)){
      // On recupere les dimensions du fichier
      $infosImg = getimagesize($_FILES['fichier']['tmp_name']);
      // On verifie le type de l'image
      if($infosImg[2] >= 1 && $infosImg[2] <= 14){
        // On verifie les dimensions et taille de l'image
        if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE)){
          // Parcours du tableau d'erreurs
          if(isset($_FILES['fichier']['error']) 
            && UPLOAD_ERR_OK === $_FILES['fichier']['error']){
            // On renomme le fichier
            $nomImage = md5(uniqid()) .'.'. $extension;
            // Si c'est OK, on teste l'upload
            if(move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET.$nomImage)){
              $message = 'Upload réussi !';
			} else {
              // Sinon on affiche une erreur systeme
              $message = 'Problème lors de l\'upload !';
            }
          } else {
            $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
          }
        }
        else
        {
          // Sinon erreur sur les dimensions et taille de l'image
          $message = 'Erreur dans les dimensions de l\'image !';
        }
      }
      else
      {
        // Sinon erreur sur le type de l'image
        $message = 'Le fichier à uploader n\'est pas une image !';
      }
    }
    else
    {
      // Sinon on affiche une erreur pour l'extension
      $message = 'L\'extension du fichier est incorrecte !';
    }
  }
else {
	header('Location: '.$origine.'.php?uuid='.$_GET['uuid']);
  }
} else {
	header('Location: index.php?uuid='.$_GET['uuid']);
	
}
?>