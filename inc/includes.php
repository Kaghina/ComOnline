<?php
$nomSite = "ComOnline";
$baseline = "Votre commune en un clic !";
$styleCSS = "css/style.css";

define('REP_HISTO', 'historiques');  // répertoire des fichiers d'historique

// initialisation de l'historique de la session
if (!isset($_SESSION['historique'])) {
	$_SESSION['historique'] = array();
}

// ajout d'une activité d'historique (avec date) à la session
function ajouterActiviteHistorique($activite) {
	$_SESSION['historique'][] = array(date("Y-m-d H:i:s") => $activite);
}
?>
