<?php
require_once '../fonctions/bddConnection.php';
require_once '../fonctions/calcul.php';
require_once '../fonctions/affichage.php';

session_start();
$admin=isAdmin();

if($admin==0){
    header("Location: visuInfo.php");
    // balise alert
}

enTete();

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupère les données du formulaire
    $infoIdCour = $_POST['infoIdCour'];
    $infoTitle = $_POST['infoTitle'];
    $infoComm = $_POST['infoComm'];
    $infoIdPhoto = $_POST['infoIdPhoto']; // Assure-toi que cette valeur est correctement gérée, surtout si tu travailles avec des fichiers uploadés

    // Prépare et exécute la requête pour insérer les données
    $sql = "INSERT INTO informations (infoIdCour, infoTitle, infoComm, infoIdPhoto) VALUES (:infoIdCour, :infoTitle, :infoComm, :infoIdPhoto)";
    $stmt = $bdd->prepare($sql);
    
    try {
        $stmt->execute(['infoIdCour' => $infoIdCour, 'infoTitle' => $infoTitle, 'infoComm' => $infoComm, 'infoIdPhoto' => $infoIdPhoto]);
        echo "Information ajoutée avec succès.";
    } catch (Exception $e) {
        die('Erreur lors de l\'ajout de l\'information : ' . $e->getMessage());
    }
}

?>

<h2>Créer une Nouvelle Information</h2>
<form action="creaInfo.php" method="post">
    <label for="infoIdCour">ID de la Course :</label>
    <input type="number" id="infoIdCour" name="infoIdCour" required><br>

    <label for="infoTitle">Titre :</label>
    <input type="text" id="infoTitle" name="infoTitle" required><br>

    <label for="infoComm">Commentaire :</label>
    <textarea id="infoComm" name="infoComm" required></textarea><br>

    <label for="infoIdPhoto">ID Photo (temporaire) :</label>
    <input type="number" id="infoIdPhoto" name="infoIdPhoto"><br>
    
    <button type="submit">Soumettre l'Information</button>
</form>
