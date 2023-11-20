<?php
session_start();
include 'navbar.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <title>Votre Panier</title>
</head>

<body>

    <?php
    // Vérifiez si le panier existe dans la session
    if (isset($_SESSION['panier']) && count($_SESSION['panier']) > 0) {
        // Le panier contient des produits, affichez-les
        echo '<h2>Votre Panier</h2>';
        echo '<ul>';

        $totalProduits = 0;
        $totalPrix = 0;

        foreach ($_SESSION['panier'] as $produit) {
            echo '<li>';
            echo '<div class="panier-item">';
            // Vous pouvez afficher les détails du produit ici (image, nom, etc.)
            echo '<p><strong>Produit ID:</strong> ' . htmlspecialchars($produit['id_produit']) . '</p>';
            echo '<p><strong>Quantité:</strong> ' . htmlspecialchars($produit['quantite']) . '</p>';

            // Assurez-vous que la clé 'prix' existe avant de l'afficher
            if (isset($produit['prix'])) {
                echo '<p><strong>Prix unitaire:</strong> ' . htmlspecialchars($produit['prix']) . ' €</p>';
                $totalProduits += $produit['quantite'];
                $totalPrix += $produit['quantite'] * $produit['prix'];
            } else {
                echo '<p>Prix unitaire non disponible</p>';
            }

            // Vous pouvez afficher d'autres détails du produit si nécessaire

            echo '</div>';
            echo '</li>';
        }

        // Afficher le total
        echo '</ul>';
        echo '<div class="total">';
        echo '<p>Total des produits: ' . $totalProduits . '</p>';
        echo '<p>Total des prix: ' . $totalPrix . ' €</p>';
        echo '</div>';
    } else {
        echo '<p>Votre panier est vide.</p>';
    }
    ?>

</body>

</html>
