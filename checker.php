<?php
session_start();

// Si l'utilisateur Peut acceder a une page et n'est pas connecté redireger vers la page login

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
