<?php
session_start();
if (!isset($_SESSION['idUtilisateur'])) {
    header("Location: index.html");
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $immatriculation = mysqli_real_escape_string($conn, $_POST['immatriculation']);
    $typeVehicule = mysqli_real_escape_string($conn, $_POST['typeVehicule']);
    $idClient = $_SESSION['idUtilisateur'];

    if (!empty($immatriculation) && !empty($typeVehicule)) {
        // Vérifier si le véhicule existe déjà
        $checkQuery = "SELECT idVehicule FROM vehicule WHERE immatriculation = '$immatriculation' AND idClient = '$idClient'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            // Si le véhicule existe, redirection vers reserver.php
            header("Location: reserver.php");
            exit();
        } else {
            // Si le véhicule n'existe pas, l'insérer
            $insertQuery = "INSERT INTO vehicule (immatriculation, typeVehicule, idClient) 
                            VALUES ('$immatriculation', '$typeVehicule', '$idClient')";
            if (mysqli_query($conn, $insertQuery)) {
                header("Location: reserver.php");
                exit();
            } else {
                $message = "Erreur lors de l'enregistrement : " . mysqli_error($conn);
            }
        }
    } else {
        $message = "Tous les champs sont obligatoires.";
    }
}

mysqli_close($conn);
include 'header.php';
?>


	
    <div class="container my-5">
        <h2 class="text-center">Enregistrer un Véhicule</h2>
        <?php if (!empty($message)) : ?>
            <div class="alert alert-info"><?= htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form method="POST" action="ajouter_vehicule.php">
            <div class="mb-3">
                <label for="immatriculation" class="form-label">Immatriculation</label>
                <input type="text" name="immatriculation" id="immatriculation" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="typeVehicule" class="form-label">Type de Véhicule</label>
                <select name="typeVehicule" id="typeVehicule" class="form-select" required>
                    <option value="">Sélectionnez un type</option>
                    <option value="Voiture">Voiture</option>
                    <option value="Moto">Moto</option>
                    <option value="Camion">Camion</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>


 <!-- Pied de page -->
    <footer class="bg-dark text-light text-center py-3">
        &copy; <?= date("Y"); ?> - Plateforme de Gestion des Stationnements, Dakar
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

