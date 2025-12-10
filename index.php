<?php
session_start();

// Si l'utilisateur est déjà connecté → redirection vers dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashbord.php");
    exit;
}

// Sinon → redirection vers la page login
header("Location: login.php");
exit;
?>