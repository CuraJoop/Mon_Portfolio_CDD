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

// Récupérer la liste des utilisateurs
$sql = "SELECT * FROM utilisateur"; // Remplacez par votre table d'utilisateurs
$result = $conn->query($sql);
include 'header.php';
?>

    <!-- Contenu principal -->
    <div class="container my-5">
        <div class="d-flex justify-content-between">
            <h1>Liste des Utilisateurs</h1>
            <a href="ajouter_utilisateur.php" class="btn btn-success">Ajouter Utilisateur</a>
        </div>

        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
					<th>Prenom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Vérifier si des utilisateurs sont présents
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['idUtilisateur'] . "</td>";
                        echo "<td>" . $row['nom'] . "</td>";
						echo "<td>" . $row['prenom'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['typeUtilisateur'] . "</td>";
                        echo "<td>
                                <a href='modifier_utilisateur.php?idUtilisateur=" . $row['idUtilisateur'] . "' class='btn btn-warning btn-sm'>Modifier</a>
                                <a href='supprimer_utilisateur.php?idUtilisateur=" . $row['idUtilisateur'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet utilisateur ?\");'>Supprimer</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Aucun utilisateur trouvé</td></tr>";
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