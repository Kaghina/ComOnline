<?php
if (isset($_POST['boutonValider'])) {
	$valeur = trim($_POST['valeur'] ?? '');
	$table  = ($_POST['champRech'] ?? '') === 'CITOYEN' ? 'CITOYEN' : 'SERVICE'; // seules valeurs autorisées
	ajouterActiviteHistorique("recherche du terme $valeur dans la table $table");

	$resultats = search($connexion, $table, $valeur);
	if (count($resultats) == 0) {
		$message = "Aucun résultat pour cette valeur !";
		unset($resultats);
	}
}
?>
