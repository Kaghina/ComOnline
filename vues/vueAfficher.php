<div class="page-titre">
    <h1>Statistiques</h1>
    <p>Vue d'ensemble des données de la région Auvergne-Rhône-Alpes.</p>
</div>

<div class="grille grille-3 kpis">
    <div class="carte kpi">
        <div class="icone">🗺️</div>
        <div><strong><?= h($departementCount) ?></strong><span>départements</span></div>
    </div>
    <div class="carte kpi">
        <div class="icone">🏘️</div>
        <div><strong><?= h($communeCount) ?></strong><span>communes</span></div>
    </div>
    <div class="carte kpi">
        <div class="icone">👥</div>
        <div><strong><?= h($citoyenCount) ?></strong><span>citoyens</span></div>
    </div>
</div>

<?php
// liste des statistiques : titre, requête, en-têtes affichés, colonnes SQL
$statistiques = array(
    array("Top-3 des départements ayant le plus de communes", $requeteTop3Departements,
          ['ID', 'Département', 'Communes'], ['ID_Departement', 'Nom_Departement', 'Nombre_de_Communes']),
    array("Top-3 des services les plus demandés", $requeteTop3Demandes,
          ['ID', 'Service', 'Demandes'], ['ID_Service', 'Libelle_Service', 'Nombre_de_Demandes']),
    array("Top-3 des services les plus proposés par les communes", $requeteTop3Services,
          ['ID', 'Service', 'Communes'], ['ID_Service', 'Libelle_Service', 'Nombre_de_Communes_Proposant']),
    array("Top-3 des communes qui réalisent le plus d'unions", $requeteTop3communes,
          ['ID', 'Commune', 'Unions'], ['ID_Commune', 'Nom_Commune', 'Nombre_Unions']),
    array("Enfants et cantine où ils mangeront le 01/01/2024", $requeteCantine,
          ['Nom', 'Prénom', 'Cantine'], ['nom', 'prenom', 'Cantine']),
    array("Enfants homonymes inscrits dans des écoles différentes", $requetePaires,
          ['Nom', 'Prénom', 'École 1', 'École 2'], ['Nom', 'Prenom', 'Ecole1', 'Ecole2']),
    array("Chaque enfant et son école actuelle", $requeteEnfants,
          ['Nom', 'Prénom', 'École'], ['Nom', 'Prenom', 'Ecole']),
);
?>

<div class="grille grille-2">
    <?php foreach ($statistiques as $i => $stat) { ?>
        <section class="carte stat">
            <h3><span class="num"><?= $i + 1 ?></span><?= h($stat[0]) ?></h3>
            <?php displayResults(executeQuery($connexion, $stat[1]), $stat[2], $stat[3]); ?>
        </section>
    <?php } ?>
</div>
