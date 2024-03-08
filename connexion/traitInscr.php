<?php
require_once '../fonctions/bddConnection.php';

$nomUser = $_POST['nomUser'];
$prenomUser = $_POST['prenomUser'];
$identifiant = $_POST['identifiant'];   
$password = $_POST['password'];
$adresse = $_POST['adresse'];
$codePostal = $_POST['codePostal'];
$ville = $_POST['ville'];
$age = $_POST['age'];
$numLicence = $_POST['numLicence'];

// Vérification du mot de passe
$longOk = strlen($password) >= 8 AND strlen($password) <= 24;
$chiffOk = preg_match_all('/[0-9]/', $password) >= 3;
$majOk = preg_match('/[A-Z]/', $password);
$carSpeOk = preg_match('/[\W]/', $password);

if ($longOk AND $chiffOk AND $majOk AND $carSpeOk) {
    // mot de passe OK
    $hash = password_hash($password, PASSWORD_DEFAULT); // Hashage du mot de passe
    
    try {
        $bdd->beginTransaction();
        
            $rec = $bdd->prepare("INSERT INTO cyclistes (cycNom, cycPrenom, cycIdentifiant, cycHash, cycAdr, cycCP, cycVille, cycAge, cycNum) VALUES (:nomUser, :prenomUser, :identifiant, :mdpHash, :adresse, :codePostal, :ville, :age, :numLicence)");
            $rec->bindParam(':nomUser', $nomUser);
            $rec->bindParam(':prenomUser', $prenomUser);
            $rec->bindParam(':identifiant', $identifiant);
            $rec->bindParam(':mdpHash', $hash);
            $rec->bindParam(':adresse', $adresse);
            $rec->bindParam(':codePostal', $codePostal);
            $rec->bindParam(':ville', $ville);
            $rec->bindParam(':age', $age, PDO::PARAM_INT);
            $rec->bindParam(':numLicence', $numLicence);
            $rec->execute();

        $bdd->commit();
        echo "Inscription réussie";
        header('Location: connexion.html');

    } catch (Exception $e) {
        $bdd->rollBack();
        echo "Erreur lors de l'inscription : " . $e->getMessage();
    }
} else {
    // Le mot de passe ne respecte pas les critères
    echo "<h3>Le mot de passe doit contenir entre 8 et 24 caractères, inclure au moins 3 chiffres, 1 majuscule et 1 caractère spécial.</h3>";
    header("Location: inscription.html");
}
?>
