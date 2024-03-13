<?php
// Vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: log_in.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}
?>

<?php
// On inclut la connexion à la base
require_once('includes/db.php');
$conn = connect();

$sql = 'SELECT * FROM `connexion`';

// On prépare la requête
$query = $conn->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('includes/close.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <script>
        function confirmDelete(id) {
            var result = confirm("Êtes-vous sûr de vouloir supprimer ce produit ?");
            if (result) {
                window.location.href = 'delete.php?id=' + id;
            }
        }
    </script>
    
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1>Liste des Comptes</h1>
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Identifiant</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php
                        // On boucle sur la variable result
                        foreach($result as $produit){
                        ?>
                            <tr>
                                <td><?= $produit['id'] ?></td>
                                <td><?= $produit['identifiant'] ?></td>
                                <td><a href="details.php?id=<?= $produit['id'] ?>">Voir</a> <a href="edit.php?id=<?= $produit['id'] ?>">Modifier</a> <button class="btn btn-danger" onclick="confirmDelete(<?= $produit['id'] ?>)">Supprimer</button></td>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <a href="add.php" class="btn btn-primary">Ajouter un compte</a>
                <br><br>
                <a href="logout.php">Déconnexion</a>
            </section>
        </div>
    </main>
</body>
</html>