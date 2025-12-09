<?php
require_once "connex.php";

// Nombre total de cours
$totalCours = $pdo->query("SELECT COUNT(*) FROM cours")->fetchColumn();
// Nombre total des equipements
$totalEquip = $pdo->query("SELECT COUNT(*) FROM equipements")->fetchColumn();

// Récupération les cours par catégorie

$stmt = $pdo->query("SELECT categorie, COUNT(*) AS total
                        FROM cours
                        WHERE categorie IS NOT NULL
                        GROUP BY categorie;
                    ");
$coursParType = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Recuperation des equipements par type 

$stmt2 = $pdo->query("SELECT type, COUNT(*) AS total 
                        FROM equipements
                        WHERE type is not null
                     GROUP BY type");
$equipParType = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// Le types de cours 
$typeCours = $pdo->query("SELECT COUNT(DISTINCT categorie)  FROM cours")->fetchColumn();
// Les types D'equipements
$typeEquipement = $pdo->query("SELECT COUNT(DISTINCT type) from equipements")->fetchColumn();
$dataCours = [];
foreach ($coursParType as $c) {
    $dataCours[] = ["label" => $c['categorie'], "total" => (int)$c['total']];
}

$dataEquip = [];
foreach ($equipParType as $e) {
    $dataEquip[] = ["label" => $e['type'], "total" => (int)$e['total']];
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FitManager - Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-gray-100 min-h-screen flex">

  <!-- La Partie Sidebar -->

  <aside class="w-64 bg-gray-700 text-white flex flex-col p-6 space-y-6">
    <h1 class="text-2xl font-bold tracking-wide">FitManager</h1>

    <nav class="flex flex-col space-y-3">
      <a href="#" class="px-4 py-2 rounded-lg hover:bg-gray-700 transition">Dashboard</a>
      <a href="cours.php" class="px-4 py-2 rounded-lg hover:bg-gray-700 transition">Cours</a>
      <a href="equipements.php" class="px-4 py-2 rounded-lg hover:bg-gray-700 transition">Équipements</a>
      <a href="association.php" class="px-4 py-2 rounded-lg hover:bg-gray-700 transition">Association</a>
      <a href="#" class="px-4 py-2 rounded-lg hover:bg-gray-700 transition">Déconnexion</a>
    </nav>
  </aside>

  <main class="flex-1 p-8 space-y-8">
    <!-- Le Titre  -->

    <header>
      <h2 class="text-3xl font-semibold text-gray-800">Dashboard d'equipe</h2>
      <p class="text-gray-600">Vue d'ensemble de la salle de sport</p>
    </header>

    <!-- les cartes des statistiques -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            <div class="p-4 bg-blue-100 rounded-full"></div>
            <div>
                <p class="text-gray-500 text-sm">Nombre de cours</p>
                <h3 class="text-2xl font-bold text-gray-800" id="card-total-cours"><?= $totalCours ?> </h3>
            </div>
        </div>

        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            <div class="p-4 bg-green-100 rounded-full"></div>
            <div>
            <p class="text-gray-500 text-sm">Nombres d'Équipements</p>
            <h3 class="text-2xl font-bold text-gray-800" id="card-total-equipements"><?=$totalEquip?></h3>
            </div>
        </div>

        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            <div class="p-4 bg-yellow-100 rounded-full"></div>
            <div>
            <p class="text-gray-500 text-sm">Types de cours</p>
            <h3 class="text-2xl font-bold text-gray-800" id="card-type-cours"><?=$typeCours?></h3>
            </div>
        </div>

        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            <div class="p-4 bg-red-100 rounded-full"></div>
            <div>
            <p class="text-gray-500 text-sm">Types d'équipements</p>
            <h3 class="text-2xl font-bold text-gray-800" id="card-type-equipements"><?=$typeEquipement?></h3>
            </div>
        </div>

    </section>
    
    <!-- Charts Section les graphes -->
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-xl font-semibold mb-4 text-gray-600">Répartition des cours par catégorie</h3>
            <canvas id="chart-cours"></canvas>
            <!-- ligne : qui contient categorie et Total de chaque categorie -->
            <?php foreach ($coursParType as $ligne): ?>
                <div class="flex justify-between border-b py-2">
                    <span><?= $ligne['categorie']?></span>
                    <span class="font-bold text-blue-600"><?= $ligne['total'] ?></span>
                </div>
            <?php endforeach;?>
        </div>

        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-xl font-semibold mb-4 text-gray-600">Répartition des équipements par type</h3>
            <canvas id="chart-equipements"></canvas>
                <?php foreach ($equipParType as $ligne): ?>
                    <div class="flex justify-between border-b py-2">
                        <span><?= $ligne['type']?></span>
                        <span class="font-bold text-green-600"><?= $ligne['total'] ?></span>
                    </div>
                <?php endforeach;?>
        </div>

    </section>
    
  </main>
  

<script>
    // Données envoyées depuis PHP vers JS
    const dataCours = <?= json_encode($dataCours) ?>;
    const dataEquip = <?= json_encode($dataEquip) ?>;

    // Graphique Cours - Doughnut
    new Chart(document.getElementById('chart-cours'), {
        type: 'doughnut',
        data: {
            labels: dataCours.map(item => item.label),
           datasets: [{
    data: dataCours.map(item => item.total),
    backgroundColor: ["#2563eb", "#7c3aed", "#f59e0b", "#ef4444", "#10b981"]
}]

        }
    });

    // Graphique Équipements - Bar
    new Chart(document.getElementById('chart-equipements'), {
        type: 'doughnut',
        data: {
            labels: dataEquip.map(item => item.label),
          datasets: [{
    data: dataEquip.map(item => item.total),
    backgroundColor: ["#374151", "#059669", "#f43f5e", "#0ea5e9", "#8b5cf6"]
}]
        }
    });
</script>

</body>
</html>

