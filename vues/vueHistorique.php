<div class="page-titre">
    <h1>Historique</h1>
    <p>Les actions effectuées pendant votre session.</p>
</div>

<div class="carte">
    <div class="entete-historique">
        <h2><?= count($_SESSION['historique']) ?> activité<?= count($_SESSION['historique']) > 1 ? 's' : '' ?></h2>
        <form action="index.php?page=historique" method="post">
            <input type="submit" name="boutonGenHisto" value="Exporter en fichier .log">
        </form>
    </div>

    <?php if (isset($message)) { ?>
        <div class="alerte alerte-succes"><?= $message ?></div>
    <?php } ?>

    <ul class="frise">
        <?php foreach ($_SESSION['historique'] as $activiteDate) {
            foreach ($activiteDate as $date => $activite) { ?>
                <li>
                    <time><?= h($date) ?></time>
                    <?= h(ucfirst($activite)) ?>
                </li>
        <?php }
        } ?>
    </ul>
</div>
