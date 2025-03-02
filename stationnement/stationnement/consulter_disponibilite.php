<?php
// Démarrer la session pour vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['idUtilisateur'])) {
    header("Location: index.html");
    exit();
}

// Connexion à la base de données
$host = "localhost";
$dbname = "stationnement";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// Recalculer la capacité disponible pour chaque stationnement
$update_query = "
    UPDATE stationnement s
    LEFT JOIN (
        SELECT idStationnement, COUNT(*) AS nbReservations
        FROM reservation
        WHERE statut = 'En cours'
        GROUP BY idStationnement
    ) r ON s.idStationnement = r.idStationnement
    SET s.capaciteDisponible = s.capaciteTotale - IFNULL(r.nbReservations, 0)
";

if (!mysqli_query($conn, $update_query)) {
    die("Erreur lors de la mise à jour des capacités disponibles : " . mysqli_error($conn));
}

// Requête pour récupérer les emplacements avec leurs informations et statuts
$query = "
    SELECT 
        s.idStationnement, 
        s.nomEmplacement, 
        s.adresse, 
        s.capaciteTotale, 
        s.capaciteDisponible,
        IF(s.capaciteDisponible > 0, 'Disponible', 'Complet') AS statut
    FROM stationnement s
    ORDER BY s.idStationnement;
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Erreur lors de la récupération des données : " . mysqli_error($conn));
}
include 'header.php';
?>


    <!-- Contenu -->
    <div class="container my-5">
        <h2 class="text-center">Liste des Emplacements</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Adresse</th>
                    <th>Capacité Totale</th>
                    <th>Capacité Disponible</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0) : ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['idStationnement']); ?></td>
                            <td><?= htmlspecialchars($row['nomEmplacement']); ?></td>
                            <td><?= htmlspecialchars($row['adresse']); ?></td>
                            <td><?= htmlspecialchars($row['capaciteTotale']); ?></td>
                            <td><?= htmlspecialchars($row['capaciteDisponible']); ?></td>
                            <td>
                                <?= htmlspecialchars($row['statut']); ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center">Aucun emplacement disponible</td>
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
// Fermer la connexion
mysqli_close($conn);
?>
