<?php
include_once("conexao.php");

// Consulta gêneros cadastrados
$result_generos = mysqli_query($conexao, "SELECT * FROM generos ORDER BY nome_genero ASC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Bibliotecária - Gêneros</title>
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
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <nav>
        <strong>Painel Bibliotecária:</strong>
        <a href="bibliotecaria_generos.php">Gêneros</a> |
        <a href="bibliotecaria_livros.php">Livros / Estoque</a> |
        <a href="bibliotecaria_clientes.php">Clientes</a> |
        <a href="bibliotecaria_emprestimos.php">Empréstimos</a>
    </nav>

    <div class="card">
        <h2>Cadastrar Gênero Literário</h2>

        <form action="processa_genero.php" method="POST">
            <div class="form-group">
                <label for="nome_genero">Nome do Gênero:</label>
                <input type="text" name="nome_genero" id="nome_genero" placeholder="Ex: Romance, Ficção..." required>
            </div>

            <button type="submit" name="btn_salvar_genero">Cadastrar Gênero</button>
        </form>
    </div>

    <h2>Gêneros Cadastrados</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome do Gênero</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_generos && mysqli_num_rows($result_generos) > 0): ?>
                <?php while ($g = mysqli_fetch_assoc($result_generos)): ?>
                    <tr>
                        <td><?php echo $g['id_genero']; ?></td>
                        <td><?php echo $g['nome_genero']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">Nenhum gênero cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>