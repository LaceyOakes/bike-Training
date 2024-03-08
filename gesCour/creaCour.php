<?php
require_once '../fonctions/bddConnection.php';
require_once '../fonctions/affichage.php';

enTete();

if (isset($_POST['creaCour'])) {
    // Le formulaire a été soumis, traitement des données d'entrée
    $courDate = $_POST['courDate'];
    $courLieu = $_POST['courLieu'];
    $courLong = $_POST['courLong'];
    
    $sql = "INSERT INTO courses (courDate, courLieu, courLong) VALUES (:courDate, :courLieu, :courLong)";
    $stmt = $bdd->prepare($sql);
    
    try {
        $stmt->execute(['courDate' => $courDate, 'courLieu' => $courLieu, 'courLong' => $courLong]);
        echo "<p>La course a été créée avec succès.</p>";
    } catch (Exception $e) {
        die('Erreur lors de la création de la course : ' . $e->getMessage());
    }
    header('Location: visuCour.php');
}

// affichage 
?>
<h2>Créer une Nouvelle Course</h2>
<form method="post">
    <pre>
Date de la course :             <input type="date" id="courDate" name="courDate" required><br>

Lieu de la course :             <input type="text" id="courLieu" name="courLieu" required><br>

Longueur de la course (en m) :  <input type="number" id="courLong" name="courLong" required><br>
    </pre>

    <button type="submit" name="creaCour">Soumettre la Course</button>
</form>
