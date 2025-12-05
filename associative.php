<?php
require_once "connex.php";

// Vérifier qu’un cours est sélectionné
if (!isset($_GET['courId'])) {
    die("Erreur : aucun cours sélectionné.");
}

$courId = intval($_GET['courId']);

// Associer un équipement

if (isset($_GET['add'])) {
    $equipId = intval($_GET['add']);
    $stmt = $pdo->prepare("INSERT IGNORE INTO cours_equipements (courId, equipe_ID) VALUES (?, ?)");
    $stmt->execute([$courId, $equipId]);
    header("Location: association.php?courId=$courId");
    exit;
}

// Désassocier un équipement
if (isset($_GET['remove'])) {
    $equipId = intval($_GET['remove']);
    $stmt = $pdo->prepare("DELETE FROM cours_equipements WHERE courId = ? AND equipe_ID = ?");
    $stmt->execute([$courId, $equipId]);
    header("Location: association.php?courId=$courId");
    exit;
}

// Récupérer le nom du cours
$stmt = $pdo->prepare("SELECT nom FROM cours WHERE courId = ?");
$stmt->execute([$courId]);
$cours = $stmt->fetch();

// Équipements déjà associés
$stmt = $pdo->prepare("SELECT e.* FROM equipements e
                       INNER JOIN cours_equipements ce ON e.equipe_ID = ce.equipe_ID
                       WHERE ce.courId = ?");
$stmt->execute([$courId]);
$associes = $stmt->fetchAll();

// Équipements non associés
$stmt = $pdo->prepare("SELECT * FROM equipements WHERE equipe_ID NOT IN
                      (SELECT equipe_ID FROM cours_equipements WHERE courId = ?)");
$stmt->execute([$courId]);
$nonAssocies = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Association Équipements ↔ Cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

    <h2 class="text-2xl font-bold text-gray-700 mb-6">
        Associer les équipements au cours :
        <span class="text-blue-600"><?= $cours['nom'] ?></span>
    </h2>

    <div class="grid grid-cols-2 gap-8">

        <!-- Équipements non associés -->
        <div class="bg-white p-5 rounded shadow">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Équipements disponibles</h3>
            <ul class="space-y-3">
                <?php foreach ($nonAssocies as $e): ?>
                <li class="flex justify-between bg-gray-50 p-3 rounded">
                    <span><?= $e['nom'] ?></span>
                    <a href="?courId=<?= $courId ?>&add=<?= $e['equipe_ID'] ?>"
                       class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                       +
                    </a>
                </li>
                <?php endforeach; ?>
                <?php if (empty($nonAssocies)) echo "<p class='text-gray-400'>Aucun</p>"; ?>
            </ul>
        </div>

        <!-- Équipements associés -->
        <div class="bg-white p-5 rounded shadow">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Déjà associés</h3>
            <ul class="space-y-3">
                <?php foreach ($associes as $e): ?>
                <li class="flex justify-between bg-gray-50 p-3 rounded">
                    <span><?= $e['nom'] ?></span>
                    <a href="?courId=<?= $courId ?>&remove=<?= $e['equipe_ID'] ?>"
                       class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                       –
                    </a>
                </li>
                <?php endforeach; ?>
                <?php if (empty($associes)) echo "<p class='text-gray-400'>Aucun associé</p>"; ?>
            </ul>
        </div>

    </div>

    <a href="cours.php"
       class="inline-block mt-6 text-blue-600 hover:underline">
       ← Retour 
    </a>

</body>
</html>
