<?php
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "fitmanager";

// try {
//     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     echo "Connected successfully (PDO)";
// } catch(PDOException $e) {
//     echo "Connection failed: " . $e->getMessage();
// }
// $conn = null; // Close connection
// // Le nombre Total de cours 
// $totalCours = $pdo->query("SELECT COUNT(*) FROM cours")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FitManager - Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
      <a href="#" class="px-4 py-2 rounded-lg hover:bg-gray-700 transition">Statistiques</a>
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
          <h3 class="text-2xl font-bold text-gray-800" id="card-total-cours">0</h3>
        </div>
      </div>

      <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
        <div class="p-4 bg-green-100 rounded-full"></div>
        <div>
          <p class="text-gray-500 text-sm">Nombres d'Équipements</p>
          <h3 class="text-2xl font-bold text-gray-800" id="card-total-equipements">0</h3>
        </div>
      </div>

      <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
        <div class="p-4 bg-yellow-100 rounded-full"></div>
        <div>
          <p class="text-gray-500 text-sm">Types de cours</p>
          <h3 class="text-2xl font-bold text-gray-800" id="card-type-cours">0</h3>
        </div>
      </div>

      <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
        <div class="p-4 bg-red-100 rounded-full"></div>
        <div>
          <p class="text-gray-500 text-sm">Types d'équipements</p>
          <h3 class="text-2xl font-bold text-gray-800" id="card-type-equipements">0</h3>
        </div>
      </div>

    </section>
    
    <!-- Charts Section -->
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <div class="bg-white shadow rounded-xl p-6">
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Répartition des cours par catégorie</h3>
        <canvas id="chart-cours"></canvas>
      </div>

      <div class="bg-white shadow rounded-xl p-6">
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Répartition des équipements par type</h3>
        <canvas id="chart-equipements"></canvas>
      </div>
    </section>
    
  </main>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- JS Dashboard Logic (à remplacer par tes données PHP) -->
  <!-- <script>
    // Exemple de données (remplacées via PHP ou fetch API)
    const dataCours = {
      labels: ['Yoga', 'Musculation', 'Cardio'],
      values: [12, 8, 5]
    };

    const dataEquip = {
      labels: ['Tapis de course', 'Haltères', 'Ballons'],
      values: [10, 25, 15]
    };

    // Chart 1
    new Chart(document.getElementById('chart-cours'), {
      type: 'doughnut',
      data: {
        labels: dataCours.labels,
        datasets: [{ data: dataCours.values }]
      }
    });

    // Chart 2
    new Chart(document.getElementById('chart-equipements'), {
      type: 'bar',
      data: {
        labels: dataEquip.labels,
        datasets: [{ data: dataEquip.values }]
      }
    });
  </script> -->
</body>
</html>

