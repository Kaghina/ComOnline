<?php
$message = "";
$succes = false;

// liste des communes pour aider la saisie (datalist dans la vue)
$listeCommunes = getCommunes($connexion);

if (isset($_POST['submit'])) {
	$libelle          = trim($_POST['libelle'] ?? '');
	$description      = trim($_POST['description'] ?? '');
	$nomCommune       = trim($_POST['nom'] ?? '');
	$periodeOuverture = trim($_POST['periode_ouverture'] ?? '');
	$gratuit          = (isset($_POST['gratuit']) && $_POST['gratuit'] == '1') ? 1 : 0;

	if ($libelle === '' || $description === '' || $nomCommune === '' || $periodeOuverture === '') {
		$message = "Tous les champs sont obligatoires.";
	} else {
		$message = ajouterServiceCommune($connexion, $libelle, $description, $nomCommune, $periodeOuverture, $gratuit);
		$succes = (strpos($message, 'avec succès') !== false);
		ajouterActiviteHistorique("ajout du service $libelle pour la commune $nomCommune");
	}
}
?>
