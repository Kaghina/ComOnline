<div class="page-titre">
    <h1>Ajouter un service</h1>
    <p>Proposez un nouveau service municipal dans une commune de la région.</p>
</div>

<div class="carte carte-formulaire">
    <?php if ($message !== "") { ?>
        <div class="alerte <?= $succes ? 'alerte-succes' : 'alerte-erreur' ?>"><?= $message ?></div>
    <?php } ?>

    <form class="formulaire" method="post" action="index.php?page=ajouter">
        <div class="champ">
            <label for="libelle">Libellé du service</label>
            <input type="text" name="libelle" id="libelle" placeholder="ex. Service Bibliothèque" required>
        </div>

        <div class="champ">
            <label for="description">Description</label>
            <textarea name="description" id="description" placeholder="Décrivez le service proposé…" required></textarea>
        </div>

        <div class="ligne">
            <div class="champ">
                <label for="nom">Commune</label>
                <input type="text" name="nom" id="nom" list="listeCommunes" placeholder="ex. Lyon" required>
                <datalist id="listeCommunes">
                    <?php foreach ($listeCommunes as $nomCommune) { ?>
                        <option value="<?= h($nomCommune) ?>">
                    <?php } ?>
                </datalist>
                <span class="aide">Commencez à taper pour voir les suggestions.</span>
            </div>

            <div class="champ">
                <label for="periode_ouverture">Période d'ouverture</label>
                <input type="text" name="periode_ouverture" id="periode_ouverture" placeholder="ex. Janvier-Mars" required>
            </div>
        </div>

        <div class="champ">
            <label for="gratuit">Service gratuit ?</label>
            <select name="gratuit" id="gratuit" required>
                <option value="1">Oui, gratuit</option>
                <option value="0">Non, payant</option>
            </select>
        </div>

        <input type="submit" name="submit" value="Ajouter le service">
    </form>
</div>
