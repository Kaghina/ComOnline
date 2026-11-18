<?php
// chiffres clés affichés sur la page d'accueil
$nbCommunes  = countInstances($connexion, 'COMMUNE');
$nbServices  = countInstances($connexion, 'SERVICE');
$nbCitoyens  = countInstances($connexion, 'CITOYEN');
$nbDemandes  = countInstances($connexion, 'DEMANDE_SCOLAIRE')
             + countInstances($connexion, 'DEMANDE_RESTAURATION')
             + countInstances($connexion, 'DEMANDE_ELECTIONS')
             + countInstances($connexion, 'DEMANDE_UNION_CIVILE')
             + countInstances($connexion, 'DEMANDE_ETAT_CIVIL')
             + countInstances($connexion, 'DEMANDE_SIGNALEMENT');
?>
