<?php
require_once 'checker.php';
require_once "connex.php";

/* ----------------------- AJOUTER UN COURS ------------------------ */
if (isset($_POST['add'])) {
    $stmt = $pdo->prepare("INSERT INTO cours (nom, categorie, dateDebut, dateFin, heure, nbmax)
                        VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['nom'],
        $_POST['categorie'],
        $_POST['dateDebut'],
        $_POST['dateFin'],
        $_POST['heure'],
        $_POST['nbmax']
    ]);
    header("Location: cours.php");
    exit;
}
/* ----------------------- MODIFIER UN COURS ------------------------ */
if (isset($_POST['update'])) {
    $stmt = $pdo->prepare("UPDATE cours 
                           SET nom=?, categorie=?, dateDebut=?, dateFin=?, heure=?, nbmax=?
                           WHERE courId=?");
    $stmt->execute([
        $_POST['nom'],
        $_POST['categorie'],
        $_POST['dateDebut'],
        $_POST['dateFin'],
        $_POST['heure'],
        $_POST['nbmax'],
        $_POST['courId']
    ]);
    header("Location:cours.php");
    exit;
}

/* ----------------------- SUPPRIMER UN COURS ------------------------ */
if(isset($_POST['delete'])){
    $stmt =$pdo->prepare("DELETE FROM cours WHERE courId=?");
    $stmt->execute([$_POST['courId']]);
    header("Location:cours.php");
    exit;
}

/* ----------------------- RÉCUPÉRATION DES COURS ------------------------ */
$cours = $pdo->query("SELECT * FROM cours ORDER BY dateDebut DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!--Les Formulaires -->

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des Cours</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <nav class="bg-gray-500 text-white p-4 ml-20 rounded-lg mb-6">
    <ul class="flex gap-20 font-semibold">
        <li><a href="dashbord.php" class="hover:text-[#4DA8DA]">Dashboard</a></li>
        <li><a href="cours.php" class="hover:text-[#4DA8DA] underline">Cours</a></li>
        <li><a href="equipements.php" class="hover:text-[#4DA8DA]">Équipements</a></li>
        <li><a href="association.php" class="hover:text-[#4DA8DA]">Association</a></li>
    </ul>
   </nav>
  <div class="max-w-5xl mx-auto">

    <h1 class="text-3xl font-bold mb-6">Gestion des Cours</h1>
    <!-- Boutton Pour Ajouter Un cours -->
    <button onclick="document.getElementById('modal-add').classList.remove('hidden')" class="bg-[#4DA8DA] text-white px-4 py-2 rounded-lg mb-4">
        + Ajouter un cours
    </button>

    <!-- TABLEAU DES COURS -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <table class="w-full border-collapse">
        <thead class="bg-gray-200 text-gray-700">
          <tr>
            <th class="p-3">Nom</th>
            <th class="p-3">Catégorie</th>
            <th class="p-3">Dates</th>
            <th class="p-3">Heure</th>
            <th class="p-3">Max</th>
            <th class="p-3">TU PEUT</th>
          </tr>
        </thead>

        <tbody>
        <?php foreach ($cours as $c): ?>
          <tr class="border-b">
            <td class="p-3"><?= $c['nom'] ?></td>
            <td class="p-3"><?= $c['categorie'] ?></td>
            <td class="p-3"><?= $c['dateDebut'] ?> -> <?= $c['dateFin'] ?></td>
            <td class="p-3"><?= $c['heure'] ?></td>
            <td class="p-3"><?= $c['nbmax'] ?></td>

            <td class="p-3 flex gap-2">
              <!-- Boutton Pour modifier un cours -->
                <button onclick="openEditModal(
                    '<?= $c['courId'] ?>',
                    '<?= $c['nom'] ?>',
                    '<?= $c['categorie'] ?>',
                    '<?= $c['dateDebut'] ?>',
                    '<?= $c['dateFin'] ?>',
                    '<?= $c['heure'] ?>',
                    '<?= $c['nbmax'] ?>'
                )"
                class="bg-yellow-500 text-white px-3 py-1 rounded">
                Modifier
              </button>
              <!-- BTN SUPPRIMER -->
              <form method="POST" onsubmit="return confirm('Voulez-vous Supprimer ce cours ?');">
                <input type="hidden" name="courId" value="<?= $c['courId'] ?>">
                <button name="delete" class="bg-red-600 text-white px-3 py-1 rounded">
                  Supprimer
                </button>
              </form>
            </td>

          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- MODAL AJOUTER -->
  <div id="modal-add" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg w-96">
      <h2 class="text-2xl font-semibold mb-4">Ajouter un cours</h2>

      <form method="POST">
        <input type="text" name="nom" placeholder="Nom" required class="w-full p-2 border rounded mb-3">
        <input type="text" name="categorie" placeholder="Catégorie" required class="w-full p-2 border rounded mb-3">
        <label for="dateDebut"class="font-semibold text-gray-500">Date Debut :</label><br>
        <input type="date" name="dateDebut" required class="w-full p-2 border rounded mb-3">
        <label for="dateFin"class="font-semibold text-gray-500">Date Fin :</label><br>
        <input type="date" name="dateFin" required class="w-full p-2 border rounded mb-3">
        <label for="heure"class="font-semibold text-gray-500">Heure :</label><br>
        <input type="time" name="heure" required class="w-full p-2 border rounded mb-3">
        <input type="number" name="nbmax" placeholder="Max participants" required class="w-full p-2 border rounded mb-3">

        <button name="add" class="bg-green-500 text-white px-4 py-2 rounded">Ajouter</button>
        <button type="button" onclick="document.getElementById('modal-add').classList.add('hidden')" class="bg-red-200 ml-2 text-white px-4 py-2 rounded">Annuler</button>
      </form>

    </div>
  </div>

  <!-- MODAL MODIFIER -->
  <div id="modal-edit" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg w-96">

      <h2 class="text-2xl font-semibold mb-4">Modifier Un cours</h2>

      <form method="POST">
        <input type="hidden" name="courId" id="edit-id">

        <input type="text" name="nom" id="edit-nom" class="w-full p-2 border rounded mb-3" required>
        <input type="text" name="categorie" id="edit-categorie" class="w-full p-2 border rounded mb-3" required>
        <input type="date" name="dateDebut" id="edit-dateDebut" class="w-full p-2 border rounded mb-3" required>
        <input type="date" name="dateFin" id="edit-dateFin" class="w-full p-2 border rounded mb-3" required>
        <input type="time" name="heure" id="edit-heure" class="w-full p-2 border rounded mb-3" required>
        <input type="number" name="nbmax" id="edit-nbmax" class="w-full p-2 border rounded mb-3" required>

        <button name="update" class="bg-yellow-600 text-white px-4 py-2 rounded">Modifier</button>
        <button type="button" onclick="document.getElementById('modal-edit').classList.add('hidden')" class="ml-2 bg-red-300 text-white px-4 py-2 rounded">Annuler</button>
      </form>
    </div>
  </div>

  <script>
    function openEditModal(id, nom, categorie, dateDebut, dateFin, heure, nbmax) {
      document.getElementById('edit-id').value = id;
      document.getElementById('edit-nom').value = nom;
      document.getElementById('edit-categorie').value = categorie;
      document.getElementById('edit-dateDebut').value = dateDebut;
      document.getElementById('edit-dateFin').value = dateFin;
      document.getElementById('edit-heure').value = heure;
      document.getElementById('edit-nbmax').value = nbmax;
      document.getElementById('modal-edit').classList.remove('hidden');
    }
  </script>
</body>
</html>
