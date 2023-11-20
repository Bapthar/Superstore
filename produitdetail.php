<?php session_start(); ?>

<?php
$dsn = 'mysql:host=localhost;dbname=SUPERSTORE;charset=utf8';
$username = 'root';
$password = 'root';

try {
    $dbh = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
    exit;
}

$id_produit = isset($_POST['id_produit']) ? $_POST['id_produit'] : null;

$query_produit = "SELECT * FROM produit WHERE id_produit = :id_produit";
$stmt_produit = $dbh->prepare($query_produit);
$stmt_produit->bindParam(':id_produit', $id_produit, PDO::PARAM_INT);
$stmt_produit->execute();
$produit = $stmt_produit->fetch(PDO::FETCH_ASSOC);

$query_avis = "SELECT note, commentaire FROM notation WHERE id_produit = :id_produit";
$stmt_avis = $dbh->prepare($query_avis);
$stmt_avis->bindParam(':id_produit', $id_produit, PDO::PARAM_INT);
$stmt_avis->execute();
$avis = $stmt_avis->fetchAll(PDO::FETCH_ASSOC);

// Ajout d'une note et d'un commentaire
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_review'])) {
    $note = $_POST['note'];
    $commentaire = $_POST['commentaire'];

    // Insérer la note et le commentaire dans la base de données
    $insert_avis = "INSERT INTO notation (id_produit, note, commentaire) VALUES (:id_produit, :note, :commentaire)";
    $stmt_insert_avis = $dbh->prepare($insert_avis);
    $stmt_insert_avis->bindParam(':id_produit', $id_produit, PDO::PARAM_INT);
    $stmt_insert_avis->bindParam(':note', $note, PDO::PARAM_INT);
    $stmt_insert_avis->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
    $stmt_insert_avis->execute();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <title>Détails du Produit</title>
</head>

<body>
    <?php
    // Vérifiez si l'utilisateur est connecté
    if (isset($_SESSION['pseudo'])) {
        include 'navbar_utilisateur.php';
    } else {
        include 'navbar.php';
    }

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

        // Ajouter au panier
        echo '<form action="ajouter_panier.php" method="post">';
        echo '<input type="hidden" name="id_produit" value="' . $produit['id_produit'] . '">';
        echo '<input type="submit" value="Ajouter au panier">';
        echo '</form>';
        echo '</div>';
        echo '</div>';

        // Formulaire de note et commentaire
        if (isset($_SESSION['pseudo'])) {
            echo '<div class="user-rating-form">';
            echo '<h3>Laisser une note et un commentaire</h3>';
            echo '<form action="" method="post">';
            echo '<label for="note">Note (de 0 à 5) :</label>';
            echo '<input type="number" name="note" min="0" max="5" required>';

            echo '<label for="commentaire">Commentaire :</label>';
            echo '<textarea name="commentaire" required></textarea>';

            echo '<input type="submit" name="submit_review" value="Envoyer">';
            echo '</form>';
            echo '</div>';
        }

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
