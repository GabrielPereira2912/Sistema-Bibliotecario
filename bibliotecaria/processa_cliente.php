<?php
include_once("conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_salvar_cliente'])) {
    $id = $_POST['id_cliente'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];

    if (empty($id)) {
        // Insere com os nomes exatos das colunas do seu banco
        $sql = "INSERT INTO clientes (nome_cliente, cpf_cliente, telefone_cliente) 
                VALUES ('$nome', '$cpf', '$telefone')";
    } else {
        // Atualiza com os nomes exatos das colunas do seu banco
        $sql = "UPDATE clientes 
                SET nome_cliente='$nome', cpf_cliente='$cpf', telefone_cliente='$telefone' 
                WHERE id_cliente='$id'";
    }

    mysqli_query($conexao, $sql);

    // Redireciona de volta para a tela de clientes
    header("Location: assistente_clientes.php");
    exit();
}
?>