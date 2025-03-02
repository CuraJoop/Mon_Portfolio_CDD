<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Gestion des Stationnements</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<!-- Barre de navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="accueil.php">Gestion Stationnements</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <!-- Menu Reservation avec sous-menus -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownReservation" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Réservation
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownReservation">
                        <li><a class="dropdown-item" href="ajouter_vehicule.php">Réserver</a></li>
                        <li><a class="dropdown-item" href="consulter_disponibilite.php">Consulter Disponibilité</a></li>
                        <li><a class="dropdown-item" href="liste_reservation.php">Liste des Réservations</a></li>
                    </ul>
                </li>

                <!-- Menu Administration avec sous-menus -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAdministration" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Administration
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownAdministration">
                        <li><a class="dropdown-item" href="utilisateur.php">Utilisateurs</a></li>
                        <li><a class="dropdown-item" href="emplacement.php">Emplacements</a></li>
                    </ul>
                </li>

                <!-- Menu Statistiques -->
                <li class="nav-item">
                    <a class="nav-link" href="statistiques.php">Statistiques</a>
                </li>

                <!-- Menu Déconnexion -->
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Déconnexion</a>
                </li>
            </ul>
        </div>
    </div>
</nav>