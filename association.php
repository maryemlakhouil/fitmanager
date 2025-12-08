<?php
require_once "connex.php";

// Traitement du formulaire
if (isset($_POST['associer'])) {
    $stmt = $pdo->prepare("INSERT INTO cours_equipements (courId, equipe_ID)
                           VALUES (?, ?)");
    $stmt->execute([$_POST['courId'], $_POST['equipe_ID']]);
}

// Récupérer les cours
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
   </nav>
<h2 class="text-2xl font-bold mb-6 text-center text-gray-600">Associer un équipement à un cours</h2>

<form method="POST" class="bg-white p-6 rounded-xl w-1/2 mx-auto space-y-4">

    <label class="block font-semibold">Cours :</label>
    <select name="courId" class="w-full border rounded p-2" required>
        <option value="" disabled selected>Choisir un cours</option>
        <?php foreach ($cours as $c): ?>
        <option value="<?= $c['courId'] ?>"><?= $c['nom'] ?></option>
        <?php endforeach; ?>
    </select>

    <label class="block font-semibold">Équipement :</label>
    <select name="equipe_ID" class="w-full border rounded p-2" required>
        <option value="" disabled selected>Choisir un équipement</option>
        <?php foreach ($equipements as $e): ?>
        <option value="<?= $e['equipe_ID'] ?>"><?= $e['nom'] ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit" name="associer"
            class="bg-blue-600 text-white w-full py-2 rounded hover:bg-blue-700">
        Associer
    </button>
</form>


<!-- Liste des associations -->
<div class="mt-10 bg-white p-6 rounded-xl shadow w-3/4 mx-auto">
    <h3 class="text-xl font-semibold mb-4">Associations existantes</h3>
    
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Cours</th>
                <th class="p-2">Équipement</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($assoc as $a): ?>
        <tr class="border-b">
            <td class="p-2"><?= $a['coursNom'] ?></td>
            <td class="p-2"><?= $a['equipNom'] ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
