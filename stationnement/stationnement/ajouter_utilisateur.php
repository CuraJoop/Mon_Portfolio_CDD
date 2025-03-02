<?php
// Démarrer la session et vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['idUtilisateur'])) {
    header("Location: index.html"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

$host = "localhost";
$dbname = "stationnement";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

$message = "";

// Traitement du formulaire d'ajout d'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $typeUtilisateur = mysqli_real_escape_string($conn, $_POST['typeUtilisateur']);

    // Vérification que les champs sont remplis
    if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($typeUtilisateur)) {
        // Insertion de l'utilisateur dans la base de données
        $sql = "INSERT INTO utilisateur (nom, prenom, email, typeUtilisateur) 
                VALUES ('$nom', '$prenom', '$email', '$typeUtilisateur')";

        if (mysqli_query($conn, $sql)) {
            $message = "Utilisateur ajouté avec succès!";
            // Redirection vers la liste des utilisateurs après ajout
            header("Location: liste_utilisateurs.php");
            exit();
        } else {
            $message = "Erreur lors de l'ajout de l'utilisateur: " . mysqli_error($conn);
        }
    } else {
        $message = "Tous les champs sont obligatoires.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter Utilisateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2 class="text-center">Ajouter un Utilisateur</h2>
    
    <?php if (!empty($message)) : ?>
        <div class="alert alert-info"><?= htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST" action="ajouter_utilisateur.php">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" name="prenom" id="prenom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="typeUtilisateur" class="form-label">Rôle</label>
            <select name="typeUtilisateur" id="typeUtilisateur" class="form-control" required>
                <option value="admin">Administrateur</option>
                <option value="utilisateur">Utilisateur</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
        <a href="liste_utilisateurs.php" class="btn btn-secondary">Retour</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
