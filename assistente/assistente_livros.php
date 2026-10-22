<?php
include_once("conexao.php");

// Consulta os livros unindo com a tabela de gêneros
$sql_livros = "SELECT l.id_livro, l.titulo_livro, l.autor_livro, l.quantidade_livro, g.nome_genero 
                FROM livros l 
                LEFT JOIN generos g ON l.id_genero = g.id_genero 
                ORDER BY l.titulo_livro ASC";

$result_livros = mysqli_query($conexao, $sql_livros);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Status dos Livros - Painel Assistente</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; color: #333; }
        nav { margin-bottom: 20px; background: #e9ecef; padding: 12px; border-radius: 6px; }
        nav a { margin-right: 15px; text-decoration: none; color: #007bff; font-weight: bold; }
        h2 { border-bottom: 2px solid #007bff; padding-bottom: 5px; color: #007bff; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .disponivel { color: green; font-weight: bold; }
        .indisponivel { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <nav>
        <strong>Painel Assistente:</strong>
        <a href="assistente_clientes.php">Clientes</a> |
        <a href="assistente_emprestimos.php">Empréstimos</a> |
        <a href="assistente_livros.php">Status dos Livros</a>
    </nav>

    <h2>Consulta de Status do Acervo</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Gênero</th>
                <th>Em Estoque</th>
                <th>Situação</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_livros && mysqli_num_rows($result_livros) > 0): ?>
                <?php while ($livro = mysqli_fetch_assoc($result_livros)): ?>
                    <tr>
                        <td><?php echo $livro['id_livro']; ?></td>
                        <td><?php echo $livro['titulo_livro']; ?></td>
                        <td><?php echo $livro['autor_livro']; ?></td>
                        <td><?php echo $livro['nome_genero'] ? $livro['nome_genero'] : 'Sem Gênero'; ?></td>
                        <td><?php echo $livro['quantidade_livro']; ?></td>
                        <td>
                            <?php if ($livro['quantidade_livro'] > 0): ?>
                                <span class="disponivel">Disponível</span>
                            <?php else: ?>
                                <span class="indisponivel">Indisponível</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Nenhum livro cadastrado no acervo.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>