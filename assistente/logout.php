<?php
include_once("conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_logout'])) {
    // Limpa todas as variáveis de sessão e destrói
    session_unset();
    session_destroy();
}

// Redireciona para a tela de login
header("Location: ../login/login.php");
exit();
?>