<?php
session_start();
include 'navbar.php';

// Vérifiez si le panier existe dans la session
if (isset($_SESSION['panier']) && count($_SESSION['panier']) > 0) {
    // Le panier contient des produits, affichez-les
    echo '<h2>Votre Panier</h2>';
    echo '<ul>';
    
    $total = 0;

    foreach ($_SESSION['panier'] as $produit) {
        echo '<li>';
        echo '<div class="panier-item">';
        if (isset($produit['image'])) {
            echo '<img src="' . htmlspecialchars($produit['image']) . '" alt="Image du produit" style="max-width: 50px;">';
        }
        echo '<div class="item-info">';
        echo '<p><strong>' . htmlspecialchars($produit['nom_album']) . '</strong></p>';
        
        // Vérifier si la clé 'prix' existe dans le produit
        if (isset($produit['prix'])) {
            echo '<p>Prix: ' . htmlspecialchars($produit['prix']) . ' €</p>';
            $total += $produit['prix'];
        } else {
            echo '<p>Prix non disponible</p>';
        }
        
        echo '</div>';
        echo '</div>';
        echo '</li>';
    }
    
    // Afficher le total
    echo '</ul>';
    echo '<div class="total">';
    echo '<p>Total: ' . $total . ' €</p>';
    echo '</div>';

} else {
    // Le panier est vide
    echo '<p>Votre panier est vide.</p>';
}
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

<!-- Le reste du contenu de votre page panierPage.php -->

</body>
</html>
