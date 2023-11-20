<?php session_start(); ?>
<?php include 'navbar.php'; ?>

<?php
// Connexion à la base de données (à remplacer par vos informations)
$dsn = 'mysql:host=localhost;dbname=SUPERSTORE;charset=utf8';
$username = 'root';
$password = 'root';

try {
    $dbh = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
    exit;
}

// Récupération de l'ID du produit depuis le formulaire
$id_produit = isset($_POST['id_produit']) ? $_POST['id_produit'] : null;

// Requête SQL pour récupérer les détails du produit
$query_produit = "SELECT * FROM produit WHERE id_produit = :id_produit";
$stmt_produit = $dbh->prepare($query_produit);
$stmt_produit->bindParam(':id_produit', $id_produit, PDO::PARAM_INT);
$stmt_produit->execute();
$produit = $stmt_produit->fetch(PDO::FETCH_ASSOC);

// Requête SQL pour récupérer les avis des utilisateurs
$query_avis = "SELECT note, commentaire FROM notation WHERE id_produit = :id_produit";
$stmt_avis = $dbh->prepare($query_avis);
$stmt_avis->bindParam(':id_produit', $id_produit, PDO::PARAM_INT);
$stmt_avis->execute();
$avis = $stmt_avis->fetchAll(PDO::FETCH_ASSOC);

// Affichage des détails du produit en HTML
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="SUPERSTORE/style.css" rel="stylesheet">
    <title>Détails du Produit</title>
</head>
<body>

<?php
if ($produit) {
    echo '<div class="product-details">';
    echo '<div class="product-image">';
    echo '<img src="' . htmlspecialchars($produit['image']) . '" alt="Image du produit" style="max-width: 100%;">';
    echo '</div>';
    echo '<div class="product-info">';
    echo '<h2>' . htmlspecialchars($produit['nom_album']) . '</h2>';
    echo '<p><strong>Artiste:</strong> ' . htmlspecialchars($produit['nom_artiste']) . '</p>';
    echo '<p><strong>Genre:</strong> ' . htmlspecialchars($produit['genre']) . '</p>';
    echo '<p><strong>Format:</strong> ' . htmlspecialchars($produit['format']) . '</p>';
    echo '<p><strong>Prix:</strong> ' . htmlspecialchars($produit['prix']) . ' €</p>';
    echo '<p><strong>Résumé:</strong> ' . htmlspecialchars($produit['resume']) . '</p>';

    // Ajout du bouton "Ajouter au panier"
    echo '<form action="connection.php" method="post">';
    echo '<input type="hidden" name="id_produit" value="' . $produit['id_produit'] . '">';
    echo '<input type="submit" value="Ajouter au panier">';
    echo '</form>';

    echo '</div>';
    echo '</div>';
    
    echo '<div class="user-reviews">';
    echo '<h3>Avis des utilisateurs</h3>';
    foreach ($avis as $review) {
        echo '<p><strong>Note:</strong> ' . htmlspecialchars($review['note']) . '/5</p>';
        echo '<p><strong>Commentaire:</strong> ' . htmlspecialchars($review['commentaire']) . '</p>';
        echo '<hr>';
    }
    echo '</div>';
} else {
    echo '<p>Produit non trouvé.</p>';
}
?>

</body>
</html>
