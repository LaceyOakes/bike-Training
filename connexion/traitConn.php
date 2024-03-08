<?php
session_start();
require_once '../fonctions/bddConnection.php';

$identUser = $_POST['identUser'];
$password = $_POST['password'];

try {
    $rec = $bdd->prepare("SELECT cycId, cycHash, cycAdmin FROM cyclistes WHERE cycIdentifiant = :identUser");
    $rec->bindParam(':identUser', $identUser);
    $rec->execute();
    $user = $rec->fetch();
    
    if ($user AND password_verify($password, $user['cycHash'])) {

        // Mot de passe correct, connexion réussie
        $_SESSION['loggedIn'] = true;
        $_SESSION['userId'] = $user['cycId'];
        $_SESSION['userName'] = $identUser;
        $_SESSION['admin'] = $user['cycAdmin'] == 1;
        
        header("Location: ./../acceuil/acceuil.php");
    } else {

        // Échec de la connexion
        echo "<script>alert('Identifiant utilisateur ou mot de passe incorrect.');window.location.href='connexion.html';</script>";
    }
} catch (Exception $e) {
    echo "Erreur lors de la connexion.";
}