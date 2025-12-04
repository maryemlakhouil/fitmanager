<?php
require_once "connex.php";

/*---------------  Ajouter Un Equipements -------------- */

if(isset($_POST['add'])) {
    $stmt = $pdo->prepare("INSERT INTO equipements (nom, type, quantite, etat)
                           VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $_POST['nom'],
        $_POST['type'],
        $_POST['quantite'],
        $_POST['etat']
    ]);
    header("Location: equipements.php");
    exit;
}
/*--------- Modifier Un Equipements -------*/

if(isset($_POST['update'])) {
    $stmt = $pdo->prepare("UPDATE equipements 
                            SET nom =?,type=?,quantite=?,etat=?
                            where equipe_ID=?");
    $stmt->execute([
        $_POST['nom'],
        $_POST['type'],
        $_POST['quantite'],
        $_POST['etat'],
        $_POST['equipe_ID']
    ]);
    header("Location: equipements.php");
    exit;
}
/* ---------Supprimer Un equipemets---------*/

if (isset($_POST['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM equipements WHERE equipe_ID=?");
    $stmt->execute([$_POST['equipe_ID']]);
    header("Location: equipements.php");
    exit;
}

/* --------Consulter la liste des equipements -------------- */
$equipements = $pdo->query("SELECT * FROM equipements ORDER BY nom ASC")->fetchAll(PDO::FETCH_ASSOC);

?>
