<?php
// Démarrer la session pour vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['idUtilisateur'])) {
    header("Location: index.html");
    exit();
}

// Définir la variable utilisateur
$idUtilisateur = $_SESSION['idUtilisateur'];

// Connexion à la base de données
$host = "localhost";
$dbname = "stationnement";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Variables pour les messages et le statut
$message = "";

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dateDebut = mysqli_real_escape_string($conn, $_POST['dateDebut']);
    $dateFin = mysqli_real_escape_string($conn, $_POST['dateFin']);
    $idStationnement = mysqli_real_escape_string($conn, $_POST['idStationnement']);
    $idVehicule = mysqli_real_escape_string($conn, $_POST['idVehicule']);

    // Vérifier que les champs ne sont pas vides
    if (!empty($dateDebut) && !empty($dateFin) && !empty($idStationnement) && !empty($idVehicule)) {
        // Insérer dans la table 'reservation'
        $sql = "INSERT INTO reservation (dateDebut, dateFin, statut, idStationnement, idVehicule)
                VALUES ('$dateDebut', '$dateFin', 'En cours', '$idStationnement', '$idVehicule')";
        
        if (mysqli_query($conn, $sql)) {
            $message = "Réservation enregistrée avec succès !";
        } else {
            $message = "Erreur lors de l'enregistrement : " . mysqli_error($conn);
        }
    } else {
        $message = "Tous les champs sont obligatoires.";
    }
}

// Récupérer les emplacements disponibles
$emplacements = [];
$result = mysqli_query($conn, "SELECT idStationnement, nomEmplacement FROM stationnement");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $emplacements[] = $row; // Ajouter l'ensemble de la ligne (ID + nom)
    }
}

// Récupérer les véhicules de l'utilisateur
$vehicules = [];
$result = mysqli_query($conn, "SELECT idVehicule, immatriculation FROM vehicule WHERE idClient = '$idUtilisateur'");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $vehicules[] = $row; // Ajouter l'ensemble de la ligne (ID + immatriculation)
    }
}

// Fermer la connexion
mysqli_close($conn);
include 'header.php';
?>


    <!-- Contenu -->
    <div class="container my-5">
        <h2 class="text-center">Formulaire de Réservation</h2>
        <?php if (!empty($message)) : ?>
            <div class="alert alert-info"><?= htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form method="POST" action="reserver.php">
            <div class="mb-3">
				<label for="idStationnement" class="form-label">Emplacement</label>
				<select name="idStationnement" id="idStationnement" class="form-select" required>
					<option value="">Sélectionnez un emplacement</option>
					<?php foreach ($emplacements as $emplacement) : ?>
						<option value="<?= htmlspecialchars($emplacement['idStationnement']); ?>">
							<?= htmlspecialchars($emplacement['nomEmplacement']); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="mb-3">
				<label for="idVehicule" class="form-label">Véhicule</label>
				<select name="idVehicule" id="idVehicule" class="form-select" required>
					<option value="">Sélectionnez un véhicule</option>
					<?php foreach ($vehicules as $vehicule) : ?>
						<option value="<?= htmlspecialchars($vehicule['idVehicule']); ?>">
							<?= htmlspecialchars($vehicule['immatriculation']); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>

            <div class="mb-3">
                <label for="dateDebut" class="form-label">Date et Heure de Début</label>
                <input type="datetime-local" name="dateDebut" id="dateDebut" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="dateFin" class="form-label">Date et Heure de Fin</label>
                <input type="datetime-local" name="dateFin" id="dateFin" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Réserver</button>
            <a href="accueil.php" class="btn btn-secondary">Retour</a>
        </form>
    </div>

    <!-- Pied de page -->
    <footer class="bg-dark text-light text-center py-3">
        &copy; <?= date("Y"); ?> - Plateforme de Gestion des Stationnements, Dakar
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
