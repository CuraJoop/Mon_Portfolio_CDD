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

if (isset($_GET['id'])) {
    $idStationnement = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "DELETE FROM stationnement WHERE idStationnement = '$idStationnement'";
    if (mysqli_query($conn, $sql)) {
        echo "Emplacement supprimé avec succès!";
    } else {
        echo "Erreur lors de la suppression: " . mysqli_error($conn);
    }
}

mysqli_close($conn);

// Redirection vers la page des emplacements après la suppression
header("Location: emplacement.php");
exit();
?>
