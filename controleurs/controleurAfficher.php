<?php
ajouterActiviteHistorique('affichage des statistiques');

// nombres d'instances
$departementCount = countInstances($connexion, 'DEPARTEMENT');
$communeCount     = countInstances($connexion, 'COMMUNE');
$citoyenCount     = countInstances($connexion, 'CITOYEN');

// Liste de chaque enfant et de son école actuelle
$requeteEnfants = "SELECT
        E.nom_Ecole AS Ecole,
        EN.nom AS Nom,
        EN.prenom AS Prenom
    FROM ENFANT EN
    JOIN DEMANDE_SCOLAIRE DS ON EN.ID_Enfant = DS.ID_Enfant
    JOIN ECOLE E ON DS.ID_Ecole = E.ID_Ecole
    ORDER BY EN.nom, EN.prenom";

// Enfants avec le nom de la cantine où ils mangeront le 01/01/2024
$requeteCantine = "SELECT
        EN.nom, EN.prenom, CA.nom AS Cantine
    FROM ENFANT EN
    JOIN DEMANDE_RESTAURATION DR ON EN.ID_Enfant = DR.ID_Enfant
    JOIN CANTINE CA ON DR.ID_Cantine = CA.ID_Cantine
    WHERE '2024-01-01' BETWEEN DR.date_debut AND DR.date_fin";

// Paires d'enfants ayant les mêmes nom et prénom, mais inscrits dans des écoles différentes
$requetePaires = "SELECT
        A.nom AS Nom, A.prenom AS Prenom, E1.nom_Ecole AS Ecole1, E2.nom_Ecole AS Ecole2
    FROM ENFANT A
    JOIN ENFANT B ON A.nom = B.nom AND A.prenom = B.prenom AND A.ID_Enfant < B.ID_Enfant
    JOIN DEMANDE_SCOLAIRE DS1 ON A.ID_Enfant = DS1.ID_Enfant
    JOIN DEMANDE_SCOLAIRE DS2 ON B.ID_Enfant = DS2.ID_Enfant
    JOIN ECOLE E1 ON DS1.ID_Ecole = E1.ID_Ecole
    JOIN ECOLE E2 ON DS2.ID_Ecole = E2.ID_Ecole
    WHERE DS1.ID_Ecole <> DS2.ID_Ecole";

// Top-3 des départements ayant le plus de communes
$requeteTop3Departements = "SELECT
        D.ID_Departement,
        D.nom AS Nom_Departement,
        COUNT(C.ID_Commune) AS Nombre_de_Communes
    FROM DEPARTEMENT D
    JOIN COMMUNE C ON D.ID_Departement = C.ID_Departement
    GROUP BY D.ID_Departement, D.nom
    ORDER BY Nombre_de_Communes DESC
    LIMIT 3";

// Top-3 des services les plus demandés
// (les demandes de restauration et scolaires concernent des enfants, pas des citoyens :
//  on compte donc le nombre de demandes de chaque service)
$requeteTop3Demandes = "SELECT
        S.ID_Service,
        S.libelle AS Libelle_Service,
        COUNT(*) AS Nombre_de_Demandes
    FROM SERVICE S
    JOIN (
        SELECT ID_Service FROM DEMANDE_RESTAURATION
        UNION ALL SELECT ID_Service FROM DEMANDE_SCOLAIRE
        UNION ALL SELECT ID_Service FROM DEMANDE_SIGNALEMENT
        UNION ALL SELECT ID_Service FROM DEMANDE_UNION_CIVILE
        UNION ALL SELECT ID_Service FROM DEMANDE_ETAT_CIVIL
        UNION ALL SELECT ID_Service FROM DEMANDE_ELECTIONS
    ) D ON S.ID_Service = D.ID_Service
    GROUP BY S.ID_Service, S.libelle
    ORDER BY Nombre_de_Demandes DESC
    LIMIT 3";

// Top-3 des services les plus proposés par les communes
$requeteTop3Services = "SELECT
        S.ID_Service,
        S.libelle AS Libelle_Service,
        COUNT(DISTINCT SC.ID_Commune) AS Nombre_de_Communes_Proposant
    FROM SERVICE S
    JOIN SERVICE_COMMUNE SC ON S.ID_Service = SC.ID_Service
    GROUP BY S.ID_Service, S.libelle
    ORDER BY Nombre_de_Communes_Proposant DESC
    LIMIT 3";

// Top-3 des communes qui réalisent le plus d'unions
// (la commune d'une union est celle du premier citoyen)
$requeteTop3communes = "SELECT
        C.ID_Commune,
        C.Nom AS Nom_Commune,
        COUNT(*) AS Nombre_Unions
    FROM DEMANDE_UNION_CIVILE DU
    JOIN CITOYEN CI ON DU.ID_Citoyen1 = CI.ID_Citoyen
    JOIN COMMUNE C ON CI.ID_Commune = C.ID_Commune
    GROUP BY C.ID_Commune, C.Nom
    ORDER BY Nombre_Unions DESC
    LIMIT 3";
?>
