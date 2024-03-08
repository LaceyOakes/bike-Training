<?php
function enTete() {
    require_once '../fonctions/calcul.php';

    session_start();

    ?>
    <link rel="stylesheet" href="../css/styles.css">

    <div class="header">
        <a href="../acceuil/acceuil.php">Accueil</a>
        <div class="dropdown">
            <a href="../information/visuInfo.php">Informations</a>

            <?php
            if (isAdmin()==1) {
                ?>
                <div class="dropdown-content">
                    <a href="../information/creaInfo.html">Créer Information</a>
                </div>
                <?php
            }
            ?>
        </div>

        <a href="../gesCour/visuCour.php">Courses</a>
        <a href="../historique/historique.php">Historique</a>
        
        <?php
        if (isAdmin() == 1) {
            ?>
            <div class="dropdown">
                <a href="#">Admin</a>
                <div class="dropdown-content">
                    <a href="../acceuil/listUserAdmin.php">Liste des Utilisateurs</a>
                </div>
            </div>
            <?php
        }
        ?>

        <div class="deconnexion">

            <?php
            if ($_SESSION['loggedIn']==true) {
                ?>
                <a href="../connexion/deconnexion.php">Déconnexion</a>
                <?php
            } else {
                ?>
                <a href="../connexion/connexion.html">Connexion</a>
                <?php
            }

            ?>
        </div>
    </div>
    <?php
}
