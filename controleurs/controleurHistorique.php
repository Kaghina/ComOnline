<?php
ajouterActiviteHistorique('consultation historique');

if (isset($_POST['boutonGenHisto'])) {
	// création du répertoire des historiques s'il n'existe pas
	if (!is_dir(REP_HISTO)) {
		mkdir(REP_HISTO, 0755, true);
	}

	// écriture du fichier (écrasé à chaque génération pour éviter les doublons)
	$nomFichier = session_id() . '.log';
	$cheminFichier = REP_HISTO . '/' . $nomFichier;
	$contenu = '';
	foreach ($_SESSION['historique'] as $activiteDate) {
		foreach ($activiteDate as $date => $activite) {
			$contenu .= "$date - $activite\n";
		}
	}

	if (file_put_contents($cheminFichier, $contenu) === false || !is_readable($cheminFichier)) {
		$message = "Une erreur s'est produite, le fichier historique n'est pas disponible.";
	} else {
		$message = 'Télécharger le <a href="' . h($cheminFichier) . '" download>fichier historique généré</a>.';
	}
}
?>
