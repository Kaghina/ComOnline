<?php

/*
** Il est possible d'automatiser le routing, notamment en cherchant directement le fichier controleur et le fichier vue.
** ex, pour page=afficher : verification de l'existence des fichiers controleurs/controleurAfficher.php et vues/vueAfficher.php
** Cela impose un nommage strict des fichiers.
*/

$routes = array(
	'Accueil' => array('controleur' => 'controleurAccueil','vue' => 'vueAccueil','css'=>'Accueil'),
	'afficher' => array('controleur' => 'controleurAfficher','vue' => 'vueAfficher','css'=>'Afficher'),
	'ajouter' => array('controleur' => 'controleurAjouter' ,'vue' => 'vueAjouter','css'=>'Ajouter'),
	'rechercher' => array('controleur' => 'controleurRechercher','vue' => 'vueRechercher','css'=>'Recherche' ),
	'historique' => array('controleur' => 'controleurHistorique','vue' => 'vueHistorique','css'=>'Historique' ),
	'Essai' => array('controleur' => 'controleurEssai', 'vue' => 'vueEssai','css'=>'Essai'),
);

// fichiers statiques
$pathHeader = 'static/header.php';
$pathMenu = 'static/menu.php';
$pathFooter = 'static/footer.php';
$controleurAccueil = 'controleurAccueil';
$vueAccueil = 'vueAccueil';
?>
