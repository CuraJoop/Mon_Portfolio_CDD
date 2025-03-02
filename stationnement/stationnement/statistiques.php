<?php
// Démarrer la session et vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['idUtilisateur'])) {
    header("Location: index.html"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

// Connexion à la base de données
$host = "localhost";
$dbname = "stationnement";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Variables pour les statistiques
$totalEmplacements = 0;
$emplacementsOccupes = 0;
$emplacementsDisponibles = 0;
$totalReservations = 0;
$revenusTotaux = 0;

// Récupérer le nombre total d'emplacements
$sql = "SELECT COUNT(*) AS total FROM stationnement";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalEmplacements = $row['total'];
}

// Récupérer le nombre d'emplacements occupés et disponibles
$sql = "SELECT COUNT(*) AS occupes FROM stationnement WHERE capaciteDisponible = 0";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $emplacementsOccupes = $row['occupes'];
}

$emplacementsDisponibles = $totalEmplacements - $emplacementsOccupes;

// Récupérer le nombre total de réservations
$sql = "SELECT COUNT(*) AS total_reservations FROM reservations";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalReservations = $row['total_reservations'];
}

// Récupérer les revenus totaux (si applicable)
$sql = "SELECT SUM(prix) AS total_revenus FROM reservations WHERE statut = 'payée'";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $revenusTotaux = $row['total_revenus'];
}

include 'header.php';
?>

<!-- Contenu principal -->
<div class="container my-5">
    <h2 class="text-center">Statistiques des Stationnements</h2>
    
    <div class="row">
        <!-- Total des Emplacements -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total des Emplacements</h5>
                    <p class="card-text"><?= $totalEmplacements; ?> emplacements</p>
                </div>
            </div>
        </div>

        <!-- Emplacements Occupés -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Emplacements Occupés</h5>
                    <p class="card-text"><?= $emplacementsOccupes; ?> emplacements</p>
                </div>
            </div>
        </div>

        <!-- Emplacements Disponibles -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Emplacements Disponibles</h5>
                    <p class="card-text"><?= $emplacementsDisponibles; ?> emplacements</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Total des Réservations -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total des Réservations</h5>
                    <p class="card-text"><?= $totalReservations; ?> réservations effectuées</p>
                </div>
            </div>
        </div>

        <!-- Revenus Totaux -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Revenus Totaux</h5>
                    <p class="card-text"><?= number_format($revenusTotaux, 2, ',', ' ') ?> FCFA</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="row mt-4">
        <!-- Graphique des Réservations -->
        <div class="col-md-12">
            <h4>Graphique des Réservations par Mois</h4>
            <canvas id="reservationsChart"></canvas>
        </div>
    </div>
</div>

<!-- Ajouter des graphiques avec Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('reservationsChart').getContext('2d');
    var reservationsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Réservations par Mois',
                data: [120, 90, 140, 160, 110, 120, 200, 180, 250, 300, 350, 400], // Remplir avec des données réelles
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Fermer la connexion à la base de données
mysqli_close($conn);
?>
