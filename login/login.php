<?php
include_once("conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema de Biblioteca</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .card-login { background: #ffffff; padding: 30px; border-radius: 8px; border: 1px solid #ddd; box-shadow: 0 4px 8px rgba(0,0,0,0.1); width: 100%; max-width: 360px; }
        h2 { color: #007bff; text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; color: #333; }
        input { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
        button { width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 16px; margin-top: 10px; }
        button:hover { background-color: #218838; }
        .erro { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; border-radius: 4px; margin-bottom: 15px; text-align: center; font-size: 14px; }
    </style>
</head>
<body>

    <div class="card-login">
        <h2>Acesso ao Sistema</h2>

        <?php if (isset($_GET['erro'])): ?>
            <div class="erro">E-mail ou senha incorretos!</div>
        <?php endif; ?>

        <form action="processa_login.php" method="POST">
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" placeholder="seuemail@biblioteca.com" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" placeholder="Sua senha" required>
            </div>

            <button type="submit" name="btn_entrar">Entrar</button>
        </form>
    </div>

</body>
</html>