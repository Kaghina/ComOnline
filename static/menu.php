<?php
// liens du menu : page => libellé
$liensMenu = array(
    'Accueil'    => 'Accueil',
    'afficher'   => 'Statistiques',
    'ajouter'    => 'Ajouter un service',
    'rechercher' => 'Rechercher',
    'historique' => 'Historique',
    'Essai'      => "Périodes d'essai",
);
?>
<nav class="menu">
    <?php foreach ($liensMenu as $page => $libelle) { ?>
        <a href="index.php?page=<?= $page ?>" class="<?= $page == $nomPage ? 'actif' : '' ?>"><?= $libelle ?></a>
    <?php } ?>
</nav>
