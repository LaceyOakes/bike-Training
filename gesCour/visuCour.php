<?php
require_once '../fonctions/bddConnection.php';
require_once '../fonctions/affichage.php'; 

enTete(); // Affiche l'en-tête de la page

$userId=$_SESSION['userId'];

// inscription course
if(isset($_POST['inscrCour'])){

        $courId = $_POST['inscrCour'];

        // Vérifier si l'utilisateur est déjà inscrit
        $verifInscr = $bdd->prepare("SELECT * FROM inscriptions WHERE inscrIdCour = :courId AND inscrIdCyc = :userId");
        $verifInscr->execute(['courId' => $courId, 'userId' => $userId]);

        if($verifInscr->rowCount() > 0) {
            // Désinscrire l'utilisateur
            $desinscr = $bdd->prepare("DELETE FROM inscriptions WHERE inscrIdCour = :courId AND inscrIdCyc = :userId");
            $desinscr->execute(['courId' => $courId, 'userId' => $userId]);
            echo "Désinscription réussie.";

        } else {
            // Inscrire l'utilisateur
            $inscr = $bdd->prepare("INSERT INTO inscriptions (inscrIdCour, inscrIdCyc) VALUES (:courId, :userId)");
            $inscr->execute(['courId' => $courId, 'userId' => $userId]);
            echo "Inscription réussie.";
        }
}

//détail course
if(isset($_POST['detCour'])){
    $courId = $_POST['detCour'];

    // Requête SQL pour récupérer les détails de la course spécifiée
    $sql = "SELECT courId, courDate, courLieu,courLong, (SELECT COUNT(*) FROM inscriptions WHERE inscrIdCour = :courId) AS participants FROM courses WHERE courId = :courId";
    
    
    try {
        $stmtDet = $bdd->prepare($sql);
        $stmtDet->execute(['courId' => $courId]);
        $detCour = $stmtDet->fetch();

        // <requete pour bouton inscription
        $sql = "SELECT inscrId FROM inscriptions WHERE inscrIdCyc = :userId AND inscrIdCour = :courId ORDER BY inscrDate DESC LIMIT 1";

        $stmt = $bdd->prepare($sql);
        $stmt->execute(['userId' => $userId, 'courId' => $courId]);
        $lastInscr = $stmt->fetch();

        // Affichage des détails de la course
        ?>
        <div>
            <h2>Détails de la course</h2>
            Date : <?php echo htmlspecialchars($detCour['courDate']); ?>
            <br>
            Lieu : <?php echo htmlspecialchars($detCour['courLieu']); ?>
            <br>
            Long : <?php echo htmlspecialchars($detCour['courLong']); ?>
            <br>
            <br>
            <form method="post">
                <?php
                if (!empty($lastInscr['inscrId'])) {
                    ?>
                    <button type='submit' name='inscrCour' value='<?php echo $courId; ?>'>Se désinscrire</button>
                    <?php
                } else {
                    ?>
                    <button type='submit' name='inscrCour' value='<?php echo $courId; ?>'>S'inscrire</button>
                    <?php
                }
                ?>
            </form>
        </div>
        <?php
    } catch (Exception $e) {
        die('Erreur lors de la récupération des détails de la course : ' . $e->getMessage());
    }
    exit();

    if($detCour['estInscrit']) {
        $sql = "SELECT inscrId, inscrDate, inscrEtat FROM inscriptions WHERE inscrIdCour = :courId AND inscrIdCyc = :userId";
        
        try {
            $stmtInscr = $bdd->prepare($sql);
            $stmtInscr->execute(['courId' => $courId, 'userId' => $userId]);
            $inscr = $stmtInscr->fetch();

            if ($inscr) {
                ?>
                <div>
                    <h3>Votre Inscription</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>ID Inscription</th>
                                <th>Date d'Inscription</th>
                                <th>État</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo htmlspecialchars($inscr['inscrId']); ?></td>
                                <td><?php echo htmlspecialchars($inscr['inscrDate']); ?></td>
                                <?php
                                if($inscr['inscrEtat']==1){
                                    ?>
                                    <td>Inscrit</td>
                                    <?php
                                }else{
                                    ?>
                                    <td>Non-Inscrit</td>
                                    <?php
                                }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php
            }
        } catch (Exception $e) {
            die('Erreur lors de la récupération des détails de votre inscription : ' . $e->getMessage());
        }
    }

}

// Requête SQL pour récupérer toutes les courses
$sql = "SELECT courId, courDate, courLieu, (SELECT COUNT(*) FROM inscriptions WHERE inscriptions.inscrIdCour = courses.courId) AS participants FROM courses ORDER BY courDate DESC";

// tentative 
// $sql = "SELECT courId, courDate, courLieu, 
//                (SELECT COUNT(*) FROM inscriptions WHERE inscriptions.inscrIdCour = courses.courId) AS participants 
//         FROM courses 
//         WHERE courDate >= CURDATE() 
//         ORDER BY courDate ASC";

try {
    $stmt = $bdd->prepare($sql);
    $stmt->execute();
    $lstCour = $stmt->fetchAll();
} catch (Exception $e) {
    die('Erreur lors de la récupération des courses : ' . $e->getMessage());
}

?>
<form action="creaCour.php" method="post">
    <!-- Bouton créatio de courses -->
    <br>
    <button type="submit">Créer une Course</button>
    <br>
</form>
<!-- Affichage du Tableau des Courses -->
<form method="post">
    <table>
        <thead>
            <th>Detail</th>
            <th>Date</th>
            <th>Lieu</th>
            <th>Participants</th>
        </thead>
        <tbody>
            <?php 
            foreach ($lstCour as $course){ 
                ?>
                <tr>
                    <td><button type="submit" name="detCour" value="<?php echo $course['courId']; ?>">Detail</button></td>
                    <td><?php echo htmlspecialchars($course['courDate']); ?></td>
                    <td><?php echo htmlspecialchars($course['courLieu']); ?></td>
                    <td><?php echo htmlspecialchars($course['participants']); ?></td>
                </tr>
                <?php 
            }
            ?>
        </tbody>
    </table>
</form>
