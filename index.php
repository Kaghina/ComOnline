<?php
// index.php fait office de contrôleur frontal
session_start(); // démarre ou reprend une session
ini_set('display_errors', 1); // affiche les erreurs (utile en développement)
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Paris'); // heure française pour l'historique

require('inc/routes.php');      // fichier des routes
require('inc/includes.php');    // informations du site (nom, slogan) + fonctions utilitaires
require('inc/config-bd.php');   // paramètres d'accès à la BD
require_once('modele/modele.php'); // fonctions d'accès aux données

$connexion = getConnexionBD(); // connexion à la BD (partagée par tous les contrôleurs)

// choix de la page à afficher (page d'accueil par défaut)
$nomPage = 'Accueil';
if (isset($_GET['page']) && isset($routes[$_GET['page']])) {
	$nomPage = $_GET['page'];
}
$controleur = $routes[$nomPage]['controleur'];
$vue        = $routes[$nomPage]['vue'];
$cssPage    = $routes[$nomPage]['css'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $nomSite ?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
	<link rel="stylesheet" href="<?= $styleCSS ?>">
	<link rel="stylesheet" href="css/<?= $cssPage ?>.css">
	<link rel="shortcut icon" type="image/png" href="img/COMM.png" />
</head>
<body>
	<?php include($pathHeader); ?>
	<main>
		<?php
		include('controleurs/' . $controleur . '.php');
		include('vues/' . $vue . '.php');
		?>
	</main>
	<?php include($pathFooter); ?>
</body>
</html>
<?php mysqli_close($connexion); ?>
