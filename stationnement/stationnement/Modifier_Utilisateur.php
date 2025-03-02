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

// Vérifier si l'ID de l'utilisateur est passé en paramètre
if (isset($_GET['idUtilisateur'])) {
    $idUtilisateur = $_GET['idUtilisateur'];
    
    // Récupérer les données de l'utilisateur à modifier
    $sql = "SELECT * FROM utilisateur WHERE idUtilisateur = '$idUtilisateur'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nom = $row['nom'];
        $prenom = $row['prenom'];
        $email = $row['email'];
        $typeUtilisateur = $row['typeUtilisateur'];
    } else {
        $message = "Utilisateur non trouvé.";
    }

    // Traitement du formulaire de modification
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = mysqli_real_escape_string($conn, $_POST['nom']);
        $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $typeUtilisateur = mysqli_real_escape_string($conn, $_POST['typeUtilisateur']);

        if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($typeUtilisateur)) {
            // Mettre à jour l'utilisateur dans la base de données
            $updateSql = "UPDATE utilisateur SET nom='$nom', prenom='$prenom', email='$email', typeUtilisateur='$typeUtilisateur' WHERE idUtilisateur='$idUtilisateur'";

            if (mysqli_query($conn, $updateSql)) {
                $message = "Utilisateur mis à jour avec succès!";
                header("Location: liste_utilisateurs.php"); // Rediriger vers la liste des utilisateurs après modification
                exit();
            } else {
                $message = "Erreur lors de la mise à jour: " . mysqli_error($conn);
            }
        } else {
            $message = "Tous les champs sont obligatoires.";
        }
    }
} else {
    $message = "Aucun utilisateur spécifié.";
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Utilisateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2 class="text-center">Modifier un Utilisateur</h2>
    
    <?php if (!empty($message)) : ?>
        <div class="alert alert-info"><?= htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST" action="modifier_utilisateur.php?idUtilisateur=<?= $idUtilisateur; ?>">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" value="<?= htmlspecialchars($nom); ?>" required>
        </div>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" name="prenom" id="prenom" class="form-control" value="<?= htmlspecialchars($prenom); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($email); ?>" required>
        </div>
        <div class="mb-3">
            <label for="typeUtilisateur" class="form-label">Rôle</label>
            <select name="typeUtilisateur" id="typeUtilisateur" class="form-control" required>
                <option value="admin" <?= ($typeUtilisateur === 'admin') ? 'selected' : ''; ?>>Administrateur</option>
                <option value="utilisateur" <?= ($typeUtilisateur === 'utilisateur') ? 'selected' : ''; ?>>Utilisateur</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="liste_utilisateurs.php" class="btn btn-secondary">Retour</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
