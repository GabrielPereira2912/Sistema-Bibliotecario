<?php
include_once("conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_realizar_emprestimo'])) {
    $id_cliente = $_POST['id_cliente'];
    $id_livro = $_POST['id_livro'];
    $data_emprestimo = date('Y-m-d');

    // 1. Cadastra o novo empréstimo
    $sql = "INSERT INTO emprestimos (id_cliente, id_livro, data_emprestimo, status) 
            VALUES ('$id_cliente', '$id_livro', '$data_emprestimo', 'ativo')";
    
    if (mysqli_query($conexao, $sql)) {
        // 2. Reduz 1 unidade do estoque do livro cadastrado
        mysqli_query($conexao, "UPDATE livros SET quantidade_livro = quantidade_livro - 1 WHERE id_livro = '$id_livro'");
    }

    // Redireciona de volta para a tela de empréstimos
    header("Location: bibliotecaria_emprestimos.php");
    exit();
}
?>