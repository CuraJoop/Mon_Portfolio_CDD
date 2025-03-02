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

// Vérifier si un ID d'emplacement est passé dans l'URL
if (isset($_GET['idStationnement'])) {
    $idStationnement = $_GET['idStationnement'];

    // Récupérer les détails de l'emplacement
    $sql = "SELECT * FROM stationnement WHERE idStationnement = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idStationnement);
    $stmt->execute();
    $result = $stmt->get_result();
    $emplacement = $result->fetch_assoc();

    if (!$emplacement) {
        die("Emplacement introuvable.");
    }
} else {
    die("ID d'emplacement non fourni.");
}

// Traitement du formulaire pour la modification
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomEmplacement = $_POST['nomEmplacement'];
    $adresse = $_POST['adresse'];
    $capaciteTotale = $_POST['capaciteTotale'];
    $capaciteDisponible = $_POST['capaciteDisponible'];

    // Mettre à jour l'emplacement dans la base de données
    $update_sql = "UPDATE stationnement SET nomEmplacement = ?, adresse = ?, capaciteTotale = ?, capaciteDisponible = ? WHERE idStationnement = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssiii", $nomEmplacement, $adresse, $capaciteTotale, $capaciteDisponible, $idStationnement);

    if ($update_stmt->execute()) {
        // Après avoir mis à jour les données, rediriger vers la page des emplacements pour afficher les changements
        header("Location: emplacement.php");
        exit(); // Assurez-vous de quitter après la redirection pour ne pas exécuter le reste du code
    } else {
        $message = "Erreur lors de la modification de l'emplacement.";
    }
}


include 'header.php';
?>

<!-- Contenu principal -->
<div class="container my-5">
    <h1>Modifier Emplacement</h1>

    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <form action="modifier_emplacement.php?idStationnement=<?php echo $idStationnement; ?>" method="POST">
        <div class="mb-3">
            <label for="nomEmplacement" class="form-label">Nom de l'Emplacement</label>
            <input type="text" class="form-control" id="nomEmplacement" name="nomEmplacement" value="<?php echo $emplacement['nomEmplacement']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <input type="text" class="form-control" id="adresse" name="adresse" value="<?php echo $emplacement['adresse']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="capaciteTotale" class="form-label">Capacité Totale</label>
            <input type="number" class="form-control" id="capaciteTotale" name="capaciteTotale" value="<?php echo $emplacement['capaciteTotale']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="capaciteDisponible" class="form-label">Capacité Disponible</label>
            <input type="number" class="form-control" id="capaciteDisponible" name="capaciteDisponible" value="<?php echo $emplacement['capaciteDisponible']; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Modifier</button>
        <a href="emplacement.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Fermer la connexion à la base de données
$conn->close();
?>
