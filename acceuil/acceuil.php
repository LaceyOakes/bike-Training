<?php
require_once '../fonctions/calcul.php';
require_once '../fonctions/bddConnection.php';
require_once '../fonctions/affichage.php';

enTete(); // Affichage de l'en-tête

// Récupération des trois dernières informations
try {
    $stmt = $bdd->query("SELECT * FROM informations ORDER BY infoId DESC LIMIT 3");
    $informations = $stmt->fetchAll();
} catch (Exception $e) {
    die('Erreur lors de la récupération des informations : ' . $e->getMessage());
}

echo '<div style="margin: 20px;">';
echo '<h2>Bienvenue sur notre site !</h2>';

foreach ($informations as $index => $info) {
    // Alternance de la disposition photo/texte
    
    if ($index == 0) { // Première information : photo à gauche, texte à droite
        echo '<div style="display: flex; align-items: center; margin-bottom: 20px;">';
        echo '<div style="margin-right: 20px;"><img src="' . htmlspecialchars($info['photoPath']) . '" alt="Image" style="width: 200px; height: auto;"></div>';
        echo '<div><h3>' . htmlspecialchars($info['titre']) . '</h3><p>' . nl2br(htmlspecialchars($info['infoComm'])) . '</p></div>';
        echo '</div>';
    } elseif ($index == 1) { // Seconde information : texte à gauche, photo à droite
        echo '<div style="display: flex; align-items: center; margin-bottom: 20px; flex-direction: row-reverse;">';
        echo '<div style="margin-left: 20px;"><img src="' . htmlspecialchars($info['photoPath']) . '" alt="Image" style="width: 200px; height: auto;"></div>';
        echo '<div><h3>' . htmlspecialchars($info['titre']) . '</h3><p>' . nl2br(htmlspecialchars($info['infoComm'])) . '</p></div>';
        echo '</div>';
    } else { // Autres informations : format standard, ici répéter la première configuration pour l'exemple
        echo '<div style="display: flex; align-items: center; margin-bottom: 20px;">';
        echo '<div style="margin-right: 20px;"><img src="' . htmlspecialchars($info['photoPath']) . '" alt="Image" style="width: 200px; height: auto;"></div>';
        echo '<div><h3>' . htmlspecialchars($info['titre']) . '</h3><p>' . nl2br(htmlspecialchars($info['infoComm'])) . '</p></div>';
        echo '</div>';
    }
}

echo '</div>';
?>
