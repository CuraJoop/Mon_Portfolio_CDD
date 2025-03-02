<?php
// Connexion à la base de données (à remplacer par vos propres informations de connexion)
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "stationnement";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }
?>
