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
    die("Erreur de connexion : " . mysqli_connect_error());
}

// Requête pour récupérer les réservations en cours
$query = "SELECT 
              reservation.idReservation,
              stationnement.nomEmplacement,
              stationnement.adresse,
              vehicule.immatriculation,
              reservation.dateDebut,
              reservation.dateFin
          FROM reservation
          INNER JOIN stationnement ON reservation.idStationnement = stationnement.idStationnement
          INNER JOIN vehicule ON reservation.idVehicule = vehicule.idVehicule
          WHERE reservation.statut = 'En cours'";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Erreur lors de la récupération des réservations : " . mysqli_error($conn));
}
include 'header.php';
?>


    <!-- Contenu principal -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Réservations en Cours</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom de l'Emplacement</th>
                    <th>Adresse</th>
                    <th>Numéro de Matricule</th>
                    <th>Date de Début</th>
                    <th>Date de Fin</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['idReservation']; ?></td>
                            <td><?= htmlspecialchars($row['nomEmplacement']); ?></td>
                            <td><?= htmlspecialchars($row['adresse']); ?></td>
                            <td><?= htmlspecialchars($row['immatriculation']); ?></td>
                            <td><?= htmlspecialchars($row['dateDebut']); ?></td>
                            <td><?= htmlspecialchars($row['dateFin']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Aucune réservation en cours.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pied de page -->
    <footer class="bg-dark text-light text-center py-3">
        &copy; <?= date("Y"); ?> - Plateforme de Gestion des Stationnements, Dakar
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
mysqli_close($conn);
?>
