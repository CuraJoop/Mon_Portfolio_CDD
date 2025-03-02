<?php
// Démarrer la session et vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['idUtilisateur'])) {
    header("Location: index.html"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

// Vérifier si l'ID de l'utilisateur est passé dans l'URL
if (isset($_GET['idUtilisateur'])) {
    $idUtilisateur = $_GET['idUtilisateur'];

    // Connexion à la base de données
    $host = "localhost";
    $dbname = "stationnement";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($host, $username, $password, $dbname);
    if (!$conn) {
        die("Erreur de connexion à la base de données : " . mysqli_connect_error());
    }

    // Vérifier si l'utilisateur existe
    $sql_check = "SELECT * FROM utilisateur WHERE idUtilisateur = $idUtilisateur";
    $result = mysqli_query($conn, $sql_check);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Supprimer l'utilisateur de la base de données
        $sql_delete = "DELETE FROM utilisateur WHERE idUtilisateur = $idUtilisateur";
        if (mysqli_query($conn, $sql_delete)) {
            // Rediriger vers la liste des utilisateurs après la suppression
            header("Location: utilisateur.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Erreur : " . mysqli_error($conn) . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Utilisateur introuvable.</div>";
    }

    // Fermer la connexion à la base de données
    mysqli_close($conn);
} else {
    echo "<div class='alert alert-danger'>Aucun ID d'utilisateur spécifié.</div>";
}
?>