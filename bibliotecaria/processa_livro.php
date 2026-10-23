<?php
include_once("conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_salvar_livro'])) {
    $id_livro = $_POST['id_livro'];
    $titulo_livro = $_POST['titulo_livro'];
    $autor_livro = $_POST['autor_livro'];
    $id_genero = $_POST['id_genero'];
    $quantidade_livro = $_POST['quantidade_livro'];

    if (empty($id_livro)) {
        // Insere novo livro no acervo[cite: 1]
        $sql = "INSERT INTO livros (titulo_livro, autor_livro, id_genero, quantidade_livro) 
                VALUES ('$titulo_livro', '$autor_livro', '$id_genero', '$quantidade_livro')";
    } else {
        // Atualiza os dados do livro e ajuste de estoque[cite: 1]
        $sql = "UPDATE livros 
                SET titulo_livro='$titulo_livro', autor_livro='$autor_livro', id_genero='$id_genero', quantidade_livro='$quantidade_livro' 
                WHERE id_livro='$id_livro'";
    }

    mysqli_query($conexao, $sql);

    header("Location: bibliotecaria_livros.php");
    exit();
}
?>