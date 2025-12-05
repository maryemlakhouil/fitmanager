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

<!-- Commancer La Partie Front End-->

<!DOCTYPE html>
    <html lang="fr">
    <head>
    <meta charset="UTF-8">
    <title>Gestion des Cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 p-8">

    <div class="max-w-5xl mx-auto">

        <h1 class="text-3xl font-bold mb-6">Gestion des Équipements</h1>
        <!-- Boutton Pour Ajouter Un eauipements -->
        <button onclick="document.getElementById('modal-add').classList.remove('hidden')" class="bg-[#4DA8DA] text-white px-4 py-2 rounded-lg mb-4">
            + Ajouter un équipement
        </button>

        <!-- TABLEAU DES Equipements -->

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full border-collapse">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="p-3">Nom</th>
                        <th class="p-3">Type</th>
                        <th class="p-3">Quantité</th>
                        <th class="p-3">État</th>
                        <th class="p-3">TU PEUT</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($equipements as $e): ?>
                    <tr class="border-b">
                        <td class="p-3"><?= $e['nom'] ?></td>
                        <td class="p-3"><?= $e['type'] ?></td>
                        <td class="p-3"><?= $e['quantite'] ?></td>
                        <td class="p-3 capitalize"><?= $e['etat'] ?></td>
                        <!-- capitalize : methode qui returne la premier caractere en majsc-->
                    <td class="p-3 flex gap-2">

                        <!-- Boutton de  MODIFIER -->
                        <button 
                            onclick="openEditModal(
                                '<?= $e['equipe_ID'] ?>',
                                '<?= $e['nom'] ?>',
                                '<?= $e['type'] ?>',
                                '<?= $e['quantite'] ?>',
                                '<?= $e['etat'] ?>'
                            )"
                            class="bg-yellow-500 text-white px-3 py-1 rounded">
                            Modifier
                        </button>

                        <!-- Boutton SUPPRIMER -->
                        <form method="POST" onsubmit="return confirm('Voulez-vous Supprimer cet équipement ?');">
                            <input type="hidden" name="equipe_ID" value="<?= $e['equipe_ID'] ?>">
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

        <h2 class="text-2xl font-semibold mb-4">Ajouter un équipement</h2>

            <form method="POST">
                <label for="nom" class="font-semibold text-gray-500">Nom :</label><br>
                <input type="text" name="nom" placeholder="Entrer Le nom de l'equipe" required class="w-full p-2 border rounded mb-3">
                <label for="type" class="font-semibold text-gray-500">Type :</label><br>
                <input type="text" name="type" placeholder="Type" required class="w-full p-2 border rounded mb-3">
                <label for="quantite" class="font-semibold text-gray-500">Quantité :</label><br>
                <input type="number" name="quantite" placeholder="Quantité" min=0 required class="w-full p-2 border rounded mb-3">
                <label for="etat" class="font-semibold text-gray-500">Etat :</label><br>
                <select name="etat" required class="w-full p-2 border rounded mb-3">
                <option value="">  Choisir l'état  </option>
                <option value="bon">Bon</option>
                <option value="moyen">Moyen</option>
                <option value="a remplacer">A remplacer</option>
                </select>
                <button name="add" class="bg-green-500 text-white px-4 py-2 rounded">Ajouter</button>
                <button type="button" onclick="document.getElementById('modal-add').classList.add('hidden')" class="bg-red-300 ml-2 text-white px-4 py-2 rounded">Annuler</button>
            </form>

        </div>
    </div>

    <!-- MODAL Pour MODIFIER UN Equipement -->

    <div id="modal-edit" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg w-96">

        <h2 class="text-2xl font-semibold mb-4">Modifier un équipement</h2>

            <form method="POST">
                <input type="hidden" name="equipe_ID" id="edit-id">
                <label for="nom" class="font-semibold text-gray-500">Nom :</label><br>
                <input type="text" name="nom" id="edit-nom" class="w-full p-2 border rounded mb-3" required>
                <label for="type" class="font-semibold text-gray-500">Type :</label><br>
                <input type="text" name="type" id="edit-type" class="w-full p-2 border rounded mb-3" required>
                <label for="quantite" class="font-semibold text-gray-500">Quantité :</label><br>
                <input type="number" name="quantite" id="edit-quantite" class="w-full p-2 border rounded mb-3" required>
                <label for="etat" class="font-semibold text-gray-500">Etat :</label><br>
                <select name="etat" id="edit-etat" class="w-full p-2 border rounded mb-3" required>
                    <option value="bon">Bon</option>
                    <option value="moyen">Moyen</option>
                    <option value="a remplacer">À remplacer</option>
                </select>

                <button name="update" class="bg-yellow-600 text-white px-4 py-2 rounded">Modifier</button>
                <button type="button" onclick="document.getElementById('modal-edit').classList.add('hidden')" class="ml-2 bg-red-300 text-white px-4 py-2 rounded">Annuler</button>
            </form>
        </div>
    </div>

    <!-- Script pour remplir le modal de modification -->

    <script>
        function openEditModal(id, nom, type, quantite, etat) {
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-nom').value = nom;
        document.getElementById('edit-type').value = type;
        document.getElementById('edit-quantite').value = quantite;
        document.getElementById('edit-etat').value = etat;

        document.getElementById('modal-edit').classList.remove('hidden');
        }
    </script>
</body>
</html>

