<section class="hero">
  <div>
    <span class="etiquette">Auvergne-Rhône-Alpes</span>
    <h1>Votre commune, <span>en un clic</span>.</h1>
    <p>
      ComOnline est votre guichet unique pour accéder aux services municipaux en ligne :
      état civil, scolarité, restauration scolaire, élections, signalements…
    </p>
    <div class="actions">
      <a class="btn" href="index.php?page=rechercher">Rechercher un service</a>
      <a class="btn btn-secondaire" href="index.php?page=afficher">Voir les statistiques</a>
    </div>
  </div>
  <img class="hero-logo" src="img/COMM.png" alt="Logo ComOnline">
</section>

<section class="grille grille-4 chiffres">
  <div class="carte chiffre"><strong><?= h($nbCommunes) ?></strong><span>communes</span></div>
  <div class="carte chiffre"><strong><?= h($nbServices) ?></strong><span>services</span></div>
  <div class="carte chiffre"><strong><?= h($nbCitoyens) ?></strong><span>citoyens inscrits</span></div>
  <div class="carte chiffre"><strong><?= h($nbDemandes) ?></strong><span>demandes traitées</span></div>
</section>

<section>
  <div class="section-titre">
    <h2>Que voulez-vous faire ?</h2>
    <p>Toutes les fonctionnalités de ComOnline, accessibles en un clic.</p>
  </div>

  <div class="grille grille-4">
    <a class="carte fonction" href="index.php?page=afficher">
      <img src="img/stats.jpg" alt="">
      <div>
        <h3>Statistiques</h3>
        <p>Écoles, cantines, unions, services les plus demandés : la région en chiffres.</p>
        <span class="lien">Consulter →</span>
      </div>
    </a>
    <a class="carte fonction" href="index.php?page=ajouter">
      <img src="img/Data-Integration-BG.jpg" alt="">
      <div>
        <h3>Ajouter un service</h3>
        <p>Proposez un nouveau service dans une commune de la région.</p>
        <span class="lien">Ajouter →</span>
      </div>
    </a>
    <a class="carte fonction" href="index.php?page=rechercher">
      <img src="img/Service.png" alt="">
      <div>
        <h3>Rechercher</h3>
        <p>Trouvez un service ou un citoyen en quelques lettres.</p>
        <span class="lien">Rechercher →</span>
      </div>
    </a>
    <a class="carte fonction" href="index.php?page=Essai">
      <img src="img/images.jpg" alt="">
      <div>
        <h3>Périodes d’essai</h3>
        <p>Générez des périodes d'essai de services pour les communes d'un département.</p>
        <span class="lien">Générer →</span>
      </div>
    </a>
  </div>
</section>
