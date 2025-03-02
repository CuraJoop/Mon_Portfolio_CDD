<?php
require 'db_connexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adresse = $_POST['adresse'];
    
    $stmt = $pdo->prepare("SELECT * FROM stationnement WHERE adresse LIKE :adresse AND capaciteDisponible > 0");
    $stmt->execute(['adresse' => "%$adresse%"]);
    $resultats = $stmt->fetchAll();

    if ($resultats) {
        foreach ($resultats as $stationnement) {
            echo "Emplacement : " . $stationnement['nomEmplacement'] . "<br>";
            echo "Adresse : " . $stationnement['adresse'] . "<br>";
            echo "Capacité disponible : " . $stationnement['capaciteDisponible'] . "<br>";
            echo "<a href='reserver.php?id=" . $stationnement['idStationnement'] . "'>Réserver</a><br><br>";
        }
    } else {
        echo "Aucun emplacement disponible.";
    }
}
?>
