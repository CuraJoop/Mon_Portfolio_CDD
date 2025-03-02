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

// Récupérer la liste des emplacements
$sql = "SELECT * FROM stationnement"; // Remplacez par votre table de stationnement
$result = $conn->query($sql);
include 'header.php';
?>

<!-- Contenu principal -->
<div class="container my-5">
    <div class="d-flex justify-content-between">
        <h1>Liste des Emplacements</h1>
        <a href="ajouter_emplacement.php" class="btn btn-success">Ajouter Emplacement</a>
    </div>

    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom Emplacement</th>
                <th>Adresse</th>
                <th>Capacité Totale</th>
                <th>Capacité Disponible</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Vérifier si des emplacements sont présents
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['idStationnement'] . "</td>";
                    echo "<td>" . $row['nomEmplacement'] . "</td>";
                    echo "<td>" . $row['adresse'] . "</td>";
                    echo "<td>" . $row['capaciteTotale'] . "</td>";
                    echo "<td>" . $row['capaciteDisponible'] . "</td>";
                    echo "<td>
                            <a href='modifier_emplacement.php?idStationnement=" . $row['idStationnement'] . "' class='btn btn-warning btn-sm'>Modifier</a>
                            <a href='supprimer_emplacement.php?idStationnement=" . $row['idStationnement'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet emplacement ?\");'>Supprimer</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>Aucun emplacement trouvé</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Fermer la connexion à la base de données
$conn->close();
?>
