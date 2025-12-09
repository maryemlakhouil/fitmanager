<?php
require_once "connex.php";

session_start();

// Pour stocke un message d'erreur 
$message = "";


if (isset($_POST['register'])) {
    // Vérifier si l’email existe déjà
    $check = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $check->execute([$_POST['email']]);
    
    if ($check->fetchColumn() > 0) {
        $message = "❌ Cet email est déjà utilisé !";
    } else {
        // Hasher le mot de passe
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Insérer dans la base
        $stmt = $pdo->prepare("INSERT INTO users (nom, email, password) VALUES (?, ?, ?)");
        $stmt->execute([
            $_POST['nom'],
            $_POST['email'],
            $hashedPassword
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
<title>Inscription</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex justify-center items-center h-screen">

<div class="bg-white p-8 shadow-lg rounded-xl w-96">
    <h2 class="text-2xl font-bold text-center text-gray-700 mb-4">Créer un compte</h2>

    <?php if ($message): ?>
        <p class="text-center text-red-600 mb-3"><?= $message ?></p>
    <?php endif; ?>

    <form method="POST" class="space-y-4">

        <input type="text" name="nom" placeholder="Nom complet" required
        class="w-full p-2 border rounded-lg">

        <input type="email" name="email" placeholder="Email" required
        class="w-full p-2 border rounded-lg">

        <input type="password" name="password" placeholder="Mot de passe" required
        class="w-full p-2 border rounded-lg">

        <button type="submit" name="register"
        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
            S'inscrire
        </button>

        <p class="text-center text-sm text-gray-500">
            Déjà un compte ? <a href="login.php" class="text-blue-600">Se connecter</a>
        </p>
    </form>
</div>

</body>
</html>
