<?php
// Démarrer la session pour vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['idUtilisateur'])) {
    header("Location: index.html"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}
include 'header.php';
?>




    <!-- Contenu principal -->
    <div class="container my-5">
        <div class="text-center">
            <h1>Bienvenue sur la Plateforme de Gestion des Stationnements</h1>
            <p class="lead">Utilisez le menu pour accéder aux différentes fonctionnalités.</p>
        </div>
    </div>

    <!-- Pied de page -->
    <footer class="bg-dark text-light text-center py-3">
        &copy; 2024 - Plateforme de Gestion des Stationnements, Dakar
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	
	
</body>
</html>
