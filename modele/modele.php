<?php
// Les paramètres de connexion ($servername, $port, $username, $password, $database)
// sont définis dans inc/config-bd.php

// échappe une valeur pour l'affichage HTML (protège contre les failles XSS)
function h($valeur) {
    return htmlspecialchars((string) $valeur, ENT_QUOTES, 'UTF-8');
}

// retourne une connexion à la base de données
function getConnexionBD() {
    global $servername, $port, $username, $password, $database;

    mysqli_report(MYSQLI_REPORT_OFF); // les erreurs sont gérées manuellement ci-dessous
    $connexion = @mysqli_connect($servername, $username, $password, $database, $port);

    if (!$connexion) {
        die("Échec de la connexion à la base de données : " . h(mysqli_connect_error())
            . "<br>Vérifiez le fichier inc/config-bd.php.");
    }

    mysqli_set_charset($connexion, 'utf8mb4');
    return $connexion;
}

// exécute une requête et affiche l'erreur éventuelle
function executeQuery($conn, $query) {
    $result = mysqli_query($conn, $query);

    if ($result) {
        return $result;
    }
    echo "<p>Erreur lors de l'exécution de la requête : " . h(mysqli_error($conn)) . "</p>";
    return false;
}

// affiche le résultat d'une requête sous forme de tableau HTML
function displayResults($result, $headers, $rowLabels) {
    if (!$result) {
        return;
    }
    if (mysqli_num_rows($result) == 0) {
        echo "<p class=\"vide\">Aucun résultat.</p>";
        return;
    }

    echo "<div class=\"table-wrap\"><table>";
    echo "<tr>";
    foreach ($headers as $header) {
        echo "<th>" . h($header) . "</th>";
    }
    echo "</tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        foreach ($rowLabels as $label) {
            echo "<td>" . (isset($row[$label]) ? h($row[$label]) : '') . "</td>";
        }
        echo "</tr>";
    }

    echo "</table></div>";
}

// nombre d'instances d'une table $nomTable
function countInstances($connexion, $nomTable) {
    $requete = "SELECT COUNT(*) AS nb FROM $nomTable";
    $res = mysqli_query($connexion, $requete);

    if ($res === FALSE) {
        die(h(mysqli_error($connexion)));
    }

    $row = mysqli_fetch_assoc($res);
    return $row['nb'];
}

// retourne les instances d'une table $nomTable
function getInstances($connexion, $nomTable) {
    $requete = "SELECT * FROM $nomTable";
    $res = mysqli_query($connexion, $requete);
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

// retourne les informations sur le service nommé $libelle
function getServiceByName($connexion, $libelle) {
    $stmt = mysqli_prepare($connexion, "SELECT * FROM SERVICE WHERE libelle = ?");
    mysqli_stmt_bind_param($stmt, "s", $libelle);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

// ajoute un service ($libelle, $description) proposé par la commune $nomCommune
// retourne un message décrivant le résultat
function ajouterServiceCommune($connexion, $libelle, $description, $nomCommune, $periodeOuverture, $gratuit) {
    // recherche de la commune
    $stmt = mysqli_prepare($connexion, "SELECT ID_Commune FROM COMMUNE WHERE Nom = ?");
    mysqli_stmt_bind_param($stmt, "s", $nomCommune);
    mysqli_stmt_execute($stmt);
    $commune = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if (!$commune) {
        return "La commune « " . h($nomCommune) . " » n'existe pas dans la base.";
    }
    $idCommune = (int) $commune['ID_Commune'];

    mysqli_begin_transaction($connexion);

    // ajout du service
    $stmt = mysqli_prepare($connexion, "INSERT INTO SERVICE (libelle, description) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $libelle, $description);
    if (!mysqli_stmt_execute($stmt)) {
        mysqli_rollback($connexion);
        return "Erreur lors de l'ajout du service : " . h(mysqli_error($connexion));
    }
    $idService = mysqli_insert_id($connexion);

    // association service / commune
    $stmt = mysqli_prepare($connexion,
        "INSERT INTO SERVICE_COMMUNE (ID_Service, ID_Commune, periode_ouverture, Gratuit) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iisi", $idService, $idCommune, $periodeOuverture, $gratuit);
    if (!mysqli_stmt_execute($stmt)) {
        mysqli_rollback($connexion);
        return "Erreur lors de l'association à la commune : " . h(mysqli_error($connexion));
    }

    mysqli_commit($connexion);
    return "Le service a été ajouté avec succès.";
}

// recherche d'un service ou d'un citoyen
function search($connexion, $table, $valeur) {
    $motif = '%' . $valeur . '%';

    if ($table == 'SERVICE') {
        $stmt = mysqli_prepare($connexion, 'SELECT * FROM SERVICE WHERE libelle LIKE ?');
        mysqli_stmt_bind_param($stmt, "s", $motif);
    } else if ($table == 'CITOYEN') {
        // jointure avec COMMUNE pour afficher le nom de la commune
        $stmt = mysqli_prepare($connexion,
            'SELECT CITOYEN.*, COMMUNE.Nom AS nom_commune
             FROM CITOYEN
             LEFT JOIN COMMUNE ON CITOYEN.ID_Commune = COMMUNE.ID_Commune
             WHERE CITOYEN.nom LIKE ? OR CITOYEN.prenom LIKE ?');
        mysqli_stmt_bind_param($stmt, "ss", $motif, $motif);
    } else {
        return array(); // table non autorisée
    }

    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

// retourne la liste des noms de communes, éventuellement filtrée par département
// ($departement peut être un nom, ex. "Rhône", ou un identifiant, ex. "10")
function getCommunes($connexion, $departement = '') {
    if ($departement === '') {
        $res = mysqli_query($connexion, 'SELECT Nom FROM COMMUNE ORDER BY Nom');
    } else {
        $stmt = mysqli_prepare($connexion,
            'SELECT C.Nom FROM COMMUNE C
             JOIN DEPARTEMENT D ON C.ID_Departement = D.ID_Departement
             WHERE D.nom LIKE ? OR D.ID_Departement = ?
             ORDER BY C.Nom');
        $motif = '%' . $departement . '%';
        $id = ctype_digit($departement) ? (int) $departement : -1;
        mysqli_stmt_bind_param($stmt, "si", $motif, $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
    }
    return array_column(mysqli_fetch_all($res, MYSQLI_ASSOC), 'Nom');
}

// retourne la liste des libellés de services
function getLibellesServices($connexion) {
    $res = mysqli_query($connexion, 'SELECT libelle FROM SERVICE');
    return array_column(mysqli_fetch_all($res, MYSQLI_ASSOC), 'libelle');
}

// génère des périodes d'essai aléatoires
// $moisMax : durée maximale d'une période (null = pas de limite)
function genererPeriodesEssai($moisMax, $communes, $services) {
    $periodesEssai = array();
    if (count($communes) == 0 || count($services) == 0) {
        return $periodesEssai;
    }

    // durées possibles (3, 4 ou 6 mois), filtrées par la durée maximale
    $durees = array(3, 4, 6);
    if ($moisMax !== null) {
        $durees = array_values(array_filter($durees, function ($d) use ($moisMax) { return $d <= $moisMax; }));
        if (count($durees) == 0) {
            return $periodesEssai; // aucune durée possible
        }
    }

    // entre 5 et 20 communes (sans doublon), dans la limite des communes disponibles
    shuffle($communes);
    $nombreCommunes = min(mt_rand(5, 20), count($communes));

    for ($i = 0; $i < $nombreCommunes; $i++) {
        $duree = $durees[array_rand($durees)];

        // entre 3 et 5 services, dans la limite des services disponibles
        $nombreServices = min(mt_rand(3, 5), count($services));
        $cles = (array) array_rand($services, $nombreServices);
        $servicesPeriode = array_intersect_key($services, array_flip($cles));

        $periodesEssai[] = array(
            'commune'  => $communes[$i],
            'duree'    => $duree,
            'services' => $servicesPeriode,
        );
    }

    return $periodesEssai;
}
?>
