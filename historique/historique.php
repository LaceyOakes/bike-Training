<?php
require_once '../fonctions/bddConnection.php';
require_once '../fonctions/affichage.php';

enTete(); // Affiche l'en-tête de la page

// Récupération des dates et lieux uniques pour les filtres
$datesQuery = $bdd->query("SELECT DISTINCT courDate FROM courses ORDER BY courDate DESC");
$dates = $datesQuery->fetchAll();

$lieuxQuery = $bdd->query("SELECT DISTINCT courLieu FROM courses ORDER BY courLieu");
$lieux = $lieuxQuery->fetchAll();

// Application des filtres
$dateFiltre = isset($_POST['dateFiltre']) ? $_POST['dateFiltre'] : '';
$lieuFiltre = isset($_POST['lieuFiltre']) ? $_POST['lieuFiltre'] : '';

$sql = "SELECT courId, courDate, courLieu, (SELECT COUNT(*) FROM inscriptions WHERE inscrIdCour = courses.courId) AS participants FROM courses WHERE 1=1";
if (!empty($dateFiltre)) {
    $sql .= " AND courDate = :dateFiltre";
}
if (!empty($lieuFiltre)) {
    $sql .= " AND courLieu LIKE :lieuFiltre";
}
$sql .= " ORDER BY courDate DESC";

$stmt = $bdd->prepare($sql);
if (!empty($dateFiltre)) {
    $stmt->bindParam(':dateFiltre', $dateFiltre);
}
if (!empty($lieuFiltre)) {
    $lieuFiltre = '%' . $lieuFiltre . '%';
    $stmt->bindParam(':lieuFiltre', $lieuFiltre);
}
$stmt->execute();
$lstCour = $stmt->fetchAll();
?>

<form method="POST">
    <table>
        <thead>
            <tr>
                <th>
                    <select name="dateFiltre">
                        <option value="">Date</option>
                        <?php foreach ($dates as $date): ?>
                            <option value="<?php echo $date['courDate']; ?>" <?php if ($date['courDate'] == $dateFiltre) echo 'selected'; ?>>
                                <?php echo $date['courDate']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </th>
                <th>
                    <select name="lieuFiltre">
                        <option value="">Lieu</option>
                        <?php foreach ($lieux as $lieu): ?>
                            <option value="<?php echo $lieu['courLieu']; ?>" <?php if ($lieu['courLieu'] == $lieuFiltre) echo 'selected'; ?>>
                                <?php echo $lieu['courLieu']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </th>
                <th>Participants</th>
                <th><input type="submit" value="Filtrer"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lstCour as $course): ?>
                <tr>
                    <td><?php echo htmlspecialchars($course['courDate']); ?></td>
                    <td><?php echo htmlspecialchars($course['courLieu']); ?></td>
                    <td><?php echo htmlspecialchars($course['participants']); ?></td>
                    <td>
                        <button type="submit" name="DetHistoCour" value="<?= $course['courId']; ?>">Détails</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</form>
