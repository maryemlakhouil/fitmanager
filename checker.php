<?php
session_start();

// Si l'utilisateur N'est PAS connecté → retour vers login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

?>
