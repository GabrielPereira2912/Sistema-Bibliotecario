<?php
include_once("conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_salvar_genero'])) {
    $nome_genero = $_POST['nome_genero'];

    // Insere o gênero usando os campos exatos do seu banco
    $sql = "INSERT INTO generos (nome_genero) VALUES ('$nome_genero')";
    mysqli_query($conexao, $sql);

    header("Location: bibliotecaria_generos.php");
    exit();
}
?>