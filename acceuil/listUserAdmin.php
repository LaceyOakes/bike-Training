<?php
require_once "../fonctions/bddConnection.php";
require_once "../fonctions/calcul.php";
require_once "../fonctions/affichage.php";
// affichage liste user pour administrateurs

enTete();

if(isAdmin()==0){
    header("Location: acceuil.php");
}

if(isset($_POST['passAdmin'])){
    $idUser = $_POST['idUser'];
    
    // Requête pour mettre à jour l'état de l'utilisateur à admin
    $sql = "UPDATE cyclistes SET cycAdmin = 1 WHERE cycId = :cycId";
    $stmt = $bdd->prepare($sql);
    
    try {
        $stmt->execute(['cycId' => $idUser]);
        echo "<script>alert('L\'utilisateur a été promu admin.'); window.location.href='listUserAdmin.php';</script>";
    } catch (Exception $e) {
        echo "Erreur lors de la promotion de l'utilisateur en admin : " . $e->getMessage();
    }
}


if(isset($_POST['detUser'])){
    // detail user + passage admnin
    
    $idUser = $_POST['detUser'];

    // Requête pour obtenir les détails de l'utilisateur
    $sql = "SELECT cycNom, cycPrenom, cycIdentifiant, cycNum, cycAdr, cycVille, cycCp, cycAge, cycDateCrea FROM cyclistes WHERE cycId = :cycId";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(['cycId' => $idUser]);
    $usrDet = $stmt->fetch();

    if ($usrDet) {
        ?>
        <h1>Détails de l'Utilisateur</h1>
        <pre>
    Nom:                <?= htmlspecialchars($usrDet['cycNom']) ?>
    <br>
    Prénom:             <?= htmlspecialchars($usrDet['cycPrenom']) ?>
    <br>
    Identifiant:        <?= htmlspecialchars($usrDet['cycIdentifiant']) ?>
    <br>
    Numéro de license:  <?= htmlspecialchars($usrDet['cycNum']) ?>
    <br>
    Adresse:            <?= htmlspecialchars($usrDet['cycAdr']) ?>
    <br>
    Code Postal:        <?= htmlspecialchars($usrDet['cycCp']) ?>
    <br>
    Ville:              <?= htmlspecialchars($usrDet['cycVille']) ?>
    <br>
    Age:                <?= htmlspecialchars($usrDet['cycAge']) ?>
    <br>
    Création du compte: <?= htmlspecialchars($usrDet['cycDateCrea']) ?>
    <form method="post">
        <input type="hidden" name="idUser" value="<?= $idUser ?>">
        <input type="submit" name="passAdmin" value="Passer en Admin">
    </form>
        </pre>
        <?php
    } else {
        echo "Utilisateur non trouvé.";
    }
    exit();
}

// Requête pour récupérer tous les utilisateurs
$sql = "SELECT cycId, cycIdentifiant, cycNom, cycPrenom, cycAdmin FROM cyclistes";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$lstUsr = $stmt->fetchAll();

?>
<h1>Liste des Utilisateurs</h1>
<form method="post">
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Identifiant Utilisateur</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>État</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($lstUsr as $user){
                ?>
                <tr>
                    <td><input type="submit" name="detUser" value="<?= htmlspecialchars($user['cycId']) ?>"></td>
                    <td><?= htmlspecialchars($user['cycIdentifiant']) ?></td>
                    <td><?= htmlspecialchars($user['cycNom']) ?></td>
                    <td><?= htmlspecialchars($user['cycPrenom']) ?></td>
                    <td><?= $user['cycAdmin'] == 1 ? 'Admin' : 'Utilisateur' ?></td>
                </tr>
                <?php 
            }
            ?>
        </tbody>
    </table>
</form>
