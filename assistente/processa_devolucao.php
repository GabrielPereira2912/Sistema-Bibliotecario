<?php
include_once("conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_devolver'])) {
    $id_emprestimo = $_POST['id_emprestimo'];
    $id_livro = $_POST['id_livro'];
    $data_devolucao = date('Y-m-d');

    // 1. Atualiza o empréstimo para devolvido e insere a data de devolução
    $sql = "UPDATE emprestimos 
            SET status = 'devolvido', data_devolucao = '$data_devolucao' 
            WHERE id_emprestimo = '$id_emprestimo'";
    
    if (mysqli_query($conexao, $sql)) {
        // 2. Aumenta 1 unidade no estoque do livro
        mysqli_query($conexao, "UPDATE livros SET quantidade_livro = quantidade_livro + 1 WHERE id_livro = '$id_livro'");
    }

    // Redireciona de volta para a tela de empréstimos
    header("Location: assistente_emprestimos.php");
    exit();
}
?>