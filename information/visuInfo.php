<?php

require_once '../fonctions/calcul.php'; 
require_once '../fonctions/bddConnection.php';
require_once '../fonctions/affichage.php';

enTete();

$admin = isAdmin();

// Récupération des informations depuis la base de données
try {
    $informations = $bdd->query("SELECT * FROM informations ORDER BY infoId DESC");
    echo '<div style="background-color: #efb51b; padding: 20px;">';

    while ($info = $informations->fetch()) {
        echo "<div style='margin-bottom: 20px;'>";
        echo "<h3>" . htmlspecialchars($info['infoIdCour']) . "</h3>"; // Utilise le titre ou un identifiant unique ici
        echo "<p>" . nl2br(htmlspecialchars($info['infoComm'])) . "</p>";
        echo "</div>";
    }
    echo '</div>';
    
    // Bouton d'ajout visible uniquement pour les administrateurs
    if ($admin==1) {
        ?>
        <div style='text-align: right; margin-top: 20px;'>
        <a href='creaInfo.html' style='padding: 10px; background-color: #4CAF50; color: white; text-decoration: none;'>Ajouter une nouvelle information</a>";
        </div>
        <?php
    }
} catch (Exception $e) {
    die('Erreur de récupération des informations : ' . $e->getMessage());
}
?>
