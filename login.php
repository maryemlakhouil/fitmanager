<?php
require_once "connex.php";  
session_start();          
// Pour stocker un message d'erreur
$error = "";

if (isset($_POST['login'])) {                      
    $email = trim($_POST['email']);                 
    $password = $_POST['password'];                 

    // Préparer la requête pour récupérer l'utilisateur par email
    $stmt = $pdo->prepare("SELECT id, nom, email, password FROM users WHERE email = ? LIMIT 1"); 
    $stmt->execute([$email]);                       
    $user = $stmt->fetch(PDO::FETCH_ASSOC);         

    if ($user) {                                    
        // Vérifier le mot de passe avec le hash stocké
        if (password_verify($password, $user['password'])) { // 11
            // Mot de passe OK -> initialiser la session
            $_SESSION['user_id'] = $user['id'];     // 12
            $_SESSION['user_name'] = $user['nom'];  // 13
            // Facultatif : régénérer l'ID de session pour éviter le session fixation
            session_regenerate_id(true);            // 14

            header("Location: dashbord.php");      // 15
            exit;
        } else {
            $error = "Email ou mot de passe incorrect."; // 16
        }
    } else {
        $error = "Email ou mot de passe incorrect.";     // 17
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Connexion</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 flex justify-center items-center h-screen">

<div class="bg-white rounded-xl shadow-lg flex w-[850px] overflow-hidden">
    
    <!-- ======== Image + Text ======== -->
    <div class="w-1/2 bg-cover bg-center p-6"
         style="background-image: url('./assests/log.jpg');">
        <h2 class="text-white text-3xl font-bold mt-10">Bienvenue </h2>
        <p class="text-white mt-4">Connectez-vous pour accéder au dashbord </p>
    </div>

    <!-- ======== Formulaire Login ======== -->
    <div class="w-1/2 p-8">
        <h2 class="text-2xl font-bold text-gray-700 mb-6">Connexion</h2>

        <?php if (!empty($message)): ?>
            <p class="text-red-600 mb-4 font-semibold"><?= $message ?></p>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <input type="email" name="email" placeholder="Email" required
            class="w-full p-2 border rounded-lg">

            <input type="password" name="password" placeholder="Mot de passe" required
            class="w-full p-2 border rounded-lg">

            <button type="submit" name="login"
            class="w-full bg-purple-700 text-white py-2 rounded-lg hover:bg-purple-800">
                Se connecter
            </button>

            <p class="text-sm text-gray-600 mt-2 text-center">
                Pas encore inscrit ? <a href="register.php" class="text-purple-700 font-semibold">Créer un compte</a>
            </p>
        </form>
    </div>

</div>

</body>

</html>
