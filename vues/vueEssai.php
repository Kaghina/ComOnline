<div class="page-titre">
    <h1>Périodes d'essai</h1>
    <p>Générez aléatoirement des périodes d'essai de services pour les communes d'un département.</p>
</div>

<div class="mise-en-page">
    <div class="carte carte-formulaire">
        <form class="formulaire" method="post" action="index.php?page=Essai">
            <div class="champ">
                <label for="departement">Département</label>
                <input type="text" id="departement" name="departement" placeholder="ex. Rhône ou 10"
                       value="<?= h($departement ?? '') ?>">
                <span class="aide">Laissez vide pour tous les départements.</span>
            </div>

            <div class="champ">
                <label for="moisMax">Durée maximale (mois)</label>
                <input type="number" id="moisMax" name="moisMax" min="1" placeholder="Illimitée"
                       value="<?= h($moisMax ?? '') ?>">
            </div>

            <div class="champ">
                <label for="kilometres">Distance (km)</label>
                <input type="number" id="kilometres" name="kilometres" min="0" placeholder="Illimitée"
                       value="<?= h($kilometres ?? '') ?>">
                <span class="aide">Critère pas encore pris en compte.</span>
            </div>

            <input type="submit" name="boutonGenerer" value="Générer">
        </form>
    </div>

    <div>
        <?php if (!isset($periodesEssai)) { ?>
            <div class="attente">Choisissez vos critères puis cliquez sur <strong>Générer</strong>.</div>
        <?php } else if (count($periodesEssai) == 0) { ?>
            <div class="alerte alerte-erreur">Aucune période d'essai ne correspond à ces critères.</div>
        <?php } else { ?>
            <h2><?= count($periodesEssai) ?> période<?= count($periodesEssai) > 1 ? 's' : '' ?> générée<?= count($periodesEssai) > 1 ? 's' : '' ?></h2>
            <div class="periodes">
                <?php foreach ($periodesEssai as $periode) { ?>
                    <div class="carte periode">
                        <div class="entete">
                            <h3><?= h($periode['commune']) ?></h3>
                            <span class="duree"><?= h($periode['duree']) ?> mois</span>
                        </div>
                        <?php foreach ($periode['services'] as $service) { ?>
                            <span class="badge"><?= h($service) ?></span>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
