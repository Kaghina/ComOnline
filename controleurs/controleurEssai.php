<?php
if (isset($_POST['boutonGenerer'])) {
	// données du formulaire
	$departement = trim($_POST['departement'] ?? '');
	$moisMax     = (isset($_POST['moisMax']) && $_POST['moisMax'] !== '') ? intval($_POST['moisMax']) : null;
	$kilometres  = (isset($_POST['kilometres']) && $_POST['kilometres'] !== '') ? intval($_POST['kilometres']) : null;

	// récupération des communes (filtrées par département) et des services
	$communes = getCommunes($connexion, $departement);
	$services = getLibellesServices($connexion);

	$periodesEssai = genererPeriodesEssai($moisMax, $communes, $services);
	ajouterActiviteHistorique('génération de périodes d\'essai' . ($departement !== '' ? " (département : $departement)" : ''));
}
?>
