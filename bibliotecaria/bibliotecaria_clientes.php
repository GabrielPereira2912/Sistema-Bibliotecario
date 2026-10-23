<?php
include_once("conexao.php");

$id_editar = "";
$nome_editar = "";
$cpf_editar = "";
$telefone_editar = "";

// 1. CARREGAR DADOS DO CLIENTE PARA EDIÇÃO (MÉTODO POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_carregar_cliente'])) {
    $id_editar = $_POST['id_cliente'];
    $sql_carregar = "SELECT * FROM clientes WHERE id_cliente = '$id_editar'";
    $res = mysqli_query($conexao, $sql_carregar);
    if ($cliente = mysqli_fetch_assoc($res)) {
        $nome_editar = $cliente['nome_cliente'];
        $cpf_editar = $cliente['cpf_cliente'];
        $telefone_editar = $cliente['telefone_cliente'];
    }
}

// 2. BUSCAR CLIENTES PARA A TABELA
$result_clientes = mysqli_query($conexao, "SELECT * FROM clientes ORDER BY nome_cliente ASC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Bibliotecária - Gestão de Clientes</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; color: #333; }
        nav { margin-bottom: 20px; background: #e9ecef; padding: 12px; border-radius: 6px; }
        nav a { margin-right: 15px; text-decoration: none; color: #007bff; font-weight: bold; }
        h2 { border-bottom: 2px solid #007bff; padding-bottom: 5px; color: #007bff; }
        .card { background: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 30px; }
        .form-group { margin-bottom: 12px; }
        label { display: block; font-weight: bold; margin-bottom: 4px; }
        input { width: 100%; max-width: 450px; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 9px 18px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .btn-acao { padding: 5px 10px; background-color: #ffc107; color: #000; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        
        .btn-logout {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: background-color 0.2s ease, transform 0.1s ease;
        }

        .btn-logout:hover {
            background-color: #c82333;
        }

        .btn-logout:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>

    <nav style="display: flex; justify-content: space-between; align-items: center; background: #e9ecef; padding: 12px 20px; border-radius: 6px; margin-bottom: 20px;">
        <strong>Painel Bibliotecária:</strong>
        <a href="bibliotecaria_generos.php">Gêneros</a> |
        <a href="bibliotecaria_livros.php">Livros / Estoque</a> |
        <a href="bibliotecaria_clientes.php">Clientes</a> |
        <a href="bibliotecaria_emprestimos.php">Empréstimos</a>
        <form action="logout.php" method="POST" style="margin: 0;">
            <button type="submit" name="btn_logout" class="btn-logout">Sair</button>
        </form>
    </nav>
    
    <div class="card">
        <h2><?php echo !empty($id_editar) ? "Atualizar Dados do Cliente" : "Cadastrar Cliente"; ?></h2>

        <!-- Formulário envia os dados para o arquivo PHP separado processa_cliente.php -->
        <form action="processa_cliente.php" method="POST">
            <input type="hidden" name="id_cliente" value="<?php echo $id_editar; ?>">

            <div class="form-group">
                <label for="nome">Nome Completo:</label>
                <input type="text" name="nome" id="nome" value="<?php echo $nome_editar; ?>" required>
            </div>

            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" name="cpf" id="cpf" value="<?php echo $cpf_editar; ?>" placeholder="000.000.000-00" required>
            </div>

            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="text" name="telefone" id="telefone" value="<?php echo $telefone_editar; ?>" required>
            </div>

            <button type="submit" name="btn_salvar_cliente">Salvar Cliente</button>
        </form>
    </div>

    <h2>Clientes Cadastrados</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_clientes && mysqli_num_rows($result_clientes) > 0): ?>
                <?php while ($cliente = mysqli_fetch_assoc($result_clientes)): ?>
                    <tr>
                        <td><?php echo $cliente['id_cliente']; ?></td>
                        <td><?php echo $cliente['nome_cliente']; ?></td>
                        <td><?php echo $cliente['cpf_cliente']; ?></td>
                        <td><?php echo $cliente['telefone_cliente']; ?></td>
                        <td>
                            <form action="assistente_clientes.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id_cliente" value="<?php echo $cliente['id_cliente']; ?>">
                                <button type="submit" name="btn_carregar_cliente" class="btn-acao">Editar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Nenhum cliente cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>