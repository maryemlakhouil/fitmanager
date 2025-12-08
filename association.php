<?php
require_once "connex.php";

// Traitement du formulaire

if (isset($_POST['associer'])) {
    $stmt = $pdo->prepare("INSERT INTO cours_equipements (courId, equipe_ID)
                           VALUES (?, ?)");
    $stmt->execute([$_POST['courId'], $_POST['equipe_ID']]);
}

// Supprimer une association

if (isset($_POST['delete_assoc'])) {
    $stmt = $pdo->prepare("DELETE FROM cours_equipements WHERE ID = ?");
    $stmt->execute([$_POST['assoc_id']]);
    header("Location: association.php");
    exit;
}

// Récupérer tous les cours avec leurs ids
$cours = $pdo->query("SELECT courId, nom FROM cours")->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les équipements
$equipements = $pdo->query("SELECT equipe_ID, nom FROM equipements")->fetchAll(PDO::FETCH_ASSOC);

// Récupérer toutes les associations

$assoc = $pdo->query("
    SELECT ce.ID, c.nom AS coursNom, e.nom AS equipNom
    FROM cours_equipements ce
    JOIN cours c ON ce.courId = c.courId
    JOIN equipements e ON ce.equipe_ID = e.equipe_ID
")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Association Cours / Équipements</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-10">
<nav class="bg-gray-500 text-white p-4 ml-20 rounded-lg mb-6">
    <ul class="flex gap-20 font-semibold">
        <li><a href="dashbord.php" class="hover:text-[#4DA8DA]">Dashboard</a></li>
        <li><a href="cours.php" class="hover:text-[#4DA8DA] ">Cours</a></li>
        <li><a href="equipements.php" class="hover:text-[#4DA8DA]">Équipements</a></li>
        <li><a href="association.php" class="hover:text-[#4DA8DA] underline">Association</a></li>
    </ul>
   </nav><h2 class="text-3xl font-bold mb-8 text-center text-gray-700">Gestion des Associations</h2>

<div class="flex gap-8 max-w-6xl mx-auto">
    
    <!-- FORMULAIRE -->
    <form method="POST" class="bg-white p-6 rounded-xl shadow w-1/3 space-y-4">
        <h3 class="text-xl font-semibold text-gray-600 mb-2">Associer</h3>

        <div>
            <label class="block font-semibold mb-1">Cours</label>
            <select name="courId" class="w-full border rounded p-2" required>
                <option value="" disabled selected>Choisir un cours</option>
                <?php foreach ($cours as $c): ?>
                <option value="<?= $c['courId'] ?>"><?= $c['nom'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block font-semibold mb-1">Équipement</label>
            <select name="equipe_ID" class="w-full border rounded p-2" required>
                <option value="" disabled selected>Choisir un équipement</option>
                <?php foreach ($equipements as $e): ?>
                <option value="<?= $e['equipe_ID'] ?>"><?= $e['nom'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" name="associer" class="bg-[#A460ED]  text-white w-full py-2 rounded hover:bg-blue-700 transition">
            Associer
        </button>
    </form>

        <!-- Tableau de associations  -->
    <div class="bg-white p-6 rounded-xl shadow w-2/3">
        <h3 class="text-xl font-semibold text-gray-600 mb-4">Associations existantes</h3>
            
        <table class="w-full border-collapse">
        <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="p-2">Cours</th>
                <th class="p-2">Équipement</th>
                <th class="p-2 text-center">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($assoc as $a): ?>
            <tr class="border-b hover:bg-gray-100">
                <td class="p-2"><?= $a['coursNom'] ?></td>
                <td class="p-2"><?= $a['equipNom'] ?></td>
                <td class="p-2 text-center">
                    <form method="POST" onsubmit="return confirm('Voulez-vous vraiment délier cet équipement ?');">
                        <input type="hidden" name="assoc_id" value="<?= $a['ID'] ?>">
                        <button name="delete_assoc" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                            Délier
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>

    </div>

</div>


</body>
</html>
