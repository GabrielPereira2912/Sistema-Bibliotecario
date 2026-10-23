<?php
include_once("conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_entrar'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consulta usuário pelo e-mail e senha
    $sql = "SELECT * FROM usuarios WHERE email_usuario = '$email' AND senha_usuario = '$senha'";
    $result = mysqli_query($conexao, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $usuario = mysqli_fetch_assoc($result);

        // Salva informações na sessão
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nome_usuario'] = $usuario['nome_usuario'];
        $_SESSION['tipo_usuario'] = $usuario['tipo'];

        // Redireciona conforme o perfil de acesso
        if ($usuario['tipo'] == 'bibliotecaria') {
            header("Location: ../bibliotecaria/bibliotecaria_livros.php");
        } else {
            header("Location: ../assistente/assistente_clientes.php");
        }
        exit();
    } else {
        // Redireciona de volta com mensagem de erro
        header("Location: login.php?erro=1");
        exit();
    }
}
?>