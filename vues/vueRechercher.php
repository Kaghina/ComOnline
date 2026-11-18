<div class="page-titre">
    <h1>Rechercher</h1>
    <p>Trouvez un service par son libellé, ou un citoyen par son nom ou son prénom.</p>
</div>

<div class="carte">
    <form class="barre-recherche" method="post" action="index.php?page=rechercher">
        <div class="champ">
            <label for="idChamp">Rechercher dans</label>
            <select name="champRech" id="idChamp">
                <option value="SERVICE">Services</option>
                <option value="CITOYEN" <?= (isset($table) && $table == 'CITOYEN') ? 'selected' : '' ?>>Citoyens</option>
            </select>
        </div>
        <div class="champ">
            <label for="idValeur">Mot-clé</label>
            <input type="text" name="valeur" id="idValeur" placeholder="ex. Martin, Scolarité…" value="<?= h($valeur ?? '') ?>" required/>
        </div>
        <input type="submit" name="boutonValider" value="Rechercher"/>
    </form>
</div>

<section class="resultats">
    <?php if (isset($message)) { ?>
        <div class="alerte"><?= h($message) ?></div>
    <?php } ?>
    <?php if (isset($resultats)) { ?>
        <p class="compteur"><?= count($resultats) ?> résultat<?= count($resultats) > 1 ? 's' : '' ?> pour « <?= h($valeur) ?> »</p>
        <div class="table-wrap">
            <table>
                <tr>
                    <?php foreach (array_keys($resultats[0]) as $header) { ?>
                        <th><?= h(str_replace('_', ' ', $header)) ?></th>
                    <?php } ?>
                </tr>
                <?php foreach ($resultats as $instance) { ?>
                    <tr>
                        <?php foreach ($instance as $champ) { ?>
                            <td><?= h($champ) ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>
        </div>
    <?php } ?>
</section>
