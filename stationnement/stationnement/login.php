<?php
// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Connexion à la base de données (à remplacer par vos propres informations de connexion)
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "stationnement";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Requête pour vérifier les informations de connexion
    $sql = "SELECT idUtilisateur, email, motDepasse, typeUtilisateur FROM utilisateur WHERE email = '$email'  AND motDepasse = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
		
		session_start ();
        foreach ($result as $row) :
            
		    $_SESSION['email'] = $_POST["email"];
		    $_SESSION['passe'] = $_POST["password"];
            $_SESSION['idUtilisateur'] = $row["idUtilisateur"];			
		    if  ($row['typeUtilisateur']=="Admin") {
            header("Location: accueil.php");
			exit();
			} else {
			header("Location: accueil2.php");
			exit();
			}				
       endforeach; 
    } else {
        // Utilisateur non trouvé
        echo "Aucun utilisateur trouvé avec cet email. Veuillez vous inscrire.";
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>
