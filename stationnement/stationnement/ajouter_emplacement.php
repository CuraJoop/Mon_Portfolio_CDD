<?php
// Connexion à la base de données
$host = "localhost";
$dbname = "stationnement";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomEmplacement = mysqli_real_escape_string($conn, $_POST['nomEmplacement']);
    $adresse = mysqli_real_escape_string($conn, $_POST['adresse']);
    $capaciteTotale = mysqli_real_escape_string($conn, $_POST['capaciteTotale']);
    $capaciteDisponible = mysqli_real_escape_string($conn, $_POST['capaciteDisponible']);

    if (!empty($nomEmplacement) && !empty($adresse) && !empty($capaciteTotale) && !empty($capaciteDisponible)) {
        $sql = "INSERT INTO stationnement (nomEmplacement, adresse, capaciteTotale, capaciteDisponible) VALUES ('$nomEmplacement', '$adresse', '$capaciteTotale', '$capaciteDisponible')";
        if (mysqli_query($conn, $sql)) {
            // Redirection vers la liste des emplacements après l'ajout réussi
            header("Location: emplacement.php");
            exit(); // Assurez-vous de quitter après la redirection
        } else {
            $message = "Erreur lors de l'ajout: " . mysqli_error($conn);
        }
    } else {
        $message = "Tous les champs sont obligatoires.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter Emplacement</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2 class="text-center">Ajouter un Emplacement</h2>
    <?php if (!empty($message)) : ?>
        <div class="alert alert-info"><?= htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form method="POST" action="ajouter_emplacement.php">
        <div class="mb-3">
            <label for="nomEmplacement" class="form-label">Nom Emplacement</label>
            <input type="text" name="nomEmplacement" id="nomEmplacement" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <input type="text" name="adresse" id="adresse" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="capaciteTotale" class="form-label">Capacité Totale</label>
            <input type="number" name="capaciteTotale" id="capaciteTotale" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="capaciteDisponible" class="form-label">Capacité Disponible</label>
            <input type="number" name="capaciteDisponible" id="capaciteDisponible" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
        <a href="emplacement.php" class="btn btn-secondary">Retour</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
