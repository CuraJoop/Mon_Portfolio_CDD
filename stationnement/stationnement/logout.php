<?php
// Démarrer la session si elle n'est pas déjà active
session_start();

// Vérifier si une session existe et la détruire
if (isset($_SESSION['idUtilisateur'])) {
    // Détruire toutes les variables de session
    $_SESSION = array();

    // Détruire la session elle-même
    session_destroy();
}

// Rediriger l'utilisateur vers la page de connexion
header("Location: index.html");
exit();
?>
