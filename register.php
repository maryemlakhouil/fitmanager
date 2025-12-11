<?php
require_once "connex.php";

session_start();
// Pour stocke un message d'erreur 
$message = "";

if (isset($_POST['register'])) {
    // Vérifier si l'email existe déjà
    $check = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $check->execute([$_POST['email']]);
    
    if ($check->fetchColumn() > 0) {
        $message = "Cet email est déjà utilisé !!";
    } else {
        // Hasher le mot de passe 
        $hasherPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Insérer dans la base
        $stmt = $pdo->prepare("INSERT INTO users (nom, email, password) VALUES (?, ?, ?)");
        $stmt->execute([
            $_POST['nom'],
            $_POST['email'],
            $hasherPassword
        ]);

        // Récupérer l’ID du nouvel utilisateur
        $userId = $pdo->lastInsertId();

        // Créer la session utilisateur
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_name'] = $_POST['nom'];

        // Redirection → Dashboard
        header("Location: dashbord.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Inscription Page</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-200 flex justify-center items-center h-screen">

    <div class="bg-white rounded-xl shadow-lg flex w-[850px] overflow-hidden">

        <div class="w-1/2 bg-cover bg-center p-6"
            style="background-image: url('./assests/log2.jpg');">
            <h2 class="text-white text-3xl font-bold mt-10">Créez un compte</h2>
            <p class="text-white mt-4">Rejoignez notre salle de sport dès maintenant</p>
        </div>
        
        <div class="w-1/2 p-8">
            <h2 class="text-2xl font-bold text-gray-700 mb-6">Inscription</h2>

            <?php if (!empty($message)): ?>
                <p class="text-red-600 mb-4 font-semibold"><?= $message ?></p>
            <?php endif; ?>

            <form method="POST" class="space-y-4">
                <input type="text" name="nom" placeholder="Nom complet" required
                class="w-full p-2 border rounded-lg">

                <input type="email" name="email" placeholder="Email" required
                class="w-full p-2 border rounded-lg">

                <input type="password" name="password" placeholder="Mot de passe" required
                class="w-full p-2 border rounded-lg">

                <button type="submit" name="register"
                class="w-full bg-purple-700 text-white py-2 rounded-lg hover:bg-purple-800">
                    S'inscrire
                </button>

                <p class="text-sm text-gray-600 mt-2 text-center">
                    Déjà un compte ? <a href="login.php" class="text-purple-700 font-semibold">Se connecter</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
