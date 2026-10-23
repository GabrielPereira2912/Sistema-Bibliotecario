<?php
include_once("conexao.php");

// Busca clientes para preencher o select
$query_clientes = mysqli_query($conexao, "SELECT id_cliente, nome_cliente, cpf_cliente FROM clientes ORDER BY nome_cliente ASC");

// Busca livros disponíveis no estoque para preencher o select
$query_livros = mysqli_query($conexao, "SELECT id_livro, titulo_livro, quantidade_livro FROM livros WHERE quantidade_livro > 0 ORDER BY titulo_livro ASC");

// Busca histórico de empréstimos cadastrados
$sql_emprestimos = "SELECT e.id_emprestimo, e.data_emprestimo, e.data_devolucao, e.status, 
                           c.nome_cliente, l.id_livro, l.titulo_livro
                    FROM emprestimos e
                    INNER JOIN clientes c ON e.id_cliente = c.id_cliente
                    INNER JOIN livros l ON e.id_livro = l.id_livro
                    ORDER BY e.status ASC, e.data_emprestimo DESC";
$result_emprestimos = mysqli_query($conexao, $sql_emprestimos);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Empréstimos - Painel Assistente</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; color: #333; }
        nav { margin-bottom: 20px; background: #e9ecef; padding: 12px; border-radius: 6px; }
        nav a { margin-right: 15px; text-decoration: none; color: #007bff; font-weight: bold; }
        h2 { border-bottom: 2px solid #007bff; padding-bottom: 5px; color: #007bff; }
        .card { background: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 30px; }
        .form-group { margin-bottom: 12px; }
        label { display: block; font-weight: bold; margin-bottom: 4px; }
        select { width: 100%; max-width: 450px; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 9px 18px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .btn-baixa { background-color: #17a2b8; color: white; padding: 5px 10px; font-size: 13px; border: none; border-radius: 4px; cursor: pointer; }
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
        <strong>Painel Assistente:</strong>
        <a href="assistente_clientes.php">Clientes</a> |
        <a href="assistente_emprestimos.php">Empréstimos</a> |
        <a href="assistente_livros.php">Status dos Livros</a>
        <form action="logout.php" method="POST" style="margin: 0;">
            <button type="submit" name="btn_logout" style="background-color: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-weight: bold;">Sair</button>
        </form>
    </nav>

    <!-- FORMULÁRIO DE EMPRÉSTIMO -->
    <div class="card">
        <h2>Realizar Novo Empréstimo</h2>

        <form action="processa_emprestimo.php" method="POST">
            <div class="form-group">
                <label for="id_cliente">Cliente:</label>
                <select name="id_cliente" id="id_cliente" required>
                    <option value="">-- Selecione o Cliente --</option>
                    <?php 
                    if ($query_clientes && mysqli_num_rows($query_clientes) > 0) {
                        while ($c = mysqli_fetch_assoc($query_clientes)) {
                            echo "<option value='" . $c['id_cliente'] . "'>" . $c['nome_cliente'] . " (CPF: " . $c['cpf_cliente'] . ")</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="id_livro">Livro Disponível:</label>
                <select name="id_livro" id="id_livro" required>
                    <option value="">-- Selecione o Livro --</option>
                    <?php 
                    if ($query_livros && mysqli_num_rows($query_livros) > 0) {
                        while ($l = mysqli_fetch_assoc($query_livros)) {
                            echo "<option value='" . $l['id_livro'] . "'>" . $l['titulo_livro'] . " (Disponíveis: " . $l['quantidade_livro'] . ")</option>";
                        }
                    } else {
                        echo "<option value=''>Nenhum livro disponível no momento</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" name="btn_realizar_emprestimo">Confirmar Empréstimo</button>
        </form>
    </div>

    <!-- TABELA DE HISTÓRICO E DAR BAIXA -->
    <h2>Empréstimos Registrados</h2>
    <table>
        <thead>
            <tr>
                <th>Data Empréstimo</th>
                <th>Cliente</th>
                <th>Livro</th>
                <th>Status</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_emprestimos && mysqli_num_rows($result_emprestimos) > 0): ?>
                <?php while ($e = mysqli_fetch_assoc($result_emprestimos)): ?>
                    <tr>
                        <td><?php echo date('d/m/Y', strtotime($e['data_emprestimo'])); ?></td>
                        <td><?php echo $e['nome_cliente']; ?></td>
                        <td><?php echo $e['titulo_livro']; ?></td>
                        <td>
                            <?php 
                            if ($e['status'] == 'ativo') {
                                echo "<strong style='color:orange;'>Ativo</strong>";
                            } else {
                                echo "<strong style='color:green;'>Devolvido em " . date('d/m/Y', strtotime($e['data_devolucao'])) . "</strong>";
                            }
                            ?>
                        </td>
                        <td>
                            <?php if ($e['status'] == 'ativo'): ?>
                                <form action="processa_devolucao.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id_emprestimo" value="<?php echo $e['id_emprestimo']; ?>">
                                    <input type="hidden" name="id_livro" value="<?php echo $e['id_livro']; ?>">
                                    <button type="submit" name="btn_devolver" class="btn-baixa">Dar Baixa / Devolver</button>
                                </form>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Nenhum empréstimo registrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>