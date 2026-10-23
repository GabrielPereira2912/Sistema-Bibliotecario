<?php
include_once("conexao.php");

$id_editar = "";
$titulo_editar = "";
$autor_editar = "";
$genero_editar = "";
$quantidade_editar = "1";

// Carrega os dados do livro para alteração/ajuste de estoque quando o botão Editar é clicado (POST)[cite: 1]
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_carregar_livro'])) {
    $id_editar = $_POST['id_livro'];
    $res = mysqli_query($conexao, "SELECT * FROM livros WHERE id_livro = '$id_editar'");
    if ($livro = mysqli_fetch_assoc($res)) {
        $titulo_editar = $livro['titulo_livro'];
        $autor_editar = $livro['autor_livro'];
        $genero_editar = $livro['id_genero'];
        $quantidade_editar = $livro['quantidade_livro'];
    }
}

// Busca gêneros cadastrados para o select
$query_generos = mysqli_query($conexao, "SELECT * FROM generos ORDER BY nome_genero ASC");

// Busca livros cadastrados para a tabela
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
    <title>Painel Bibliotecária - Acervo e Estoque</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; color: #333; }
        nav { margin-bottom: 20px; background: #e9ecef; padding: 12px; border-radius: 6px; }
        nav a { margin-right: 15px; text-decoration: none; color: #007bff; font-weight: bold; }
        h2 { border-bottom: 2px solid #007bff; padding-bottom: 5px; color: #007bff; }
        .card { background: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 30px; }
        .form-group { margin-bottom: 12px; }
        label { display: block; font-weight: bold; margin-bottom: 4px; }
        select, input { width: 100%; max-width: 450px; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 9px 18px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .btn-acao { padding: 5px 10px; background-color: #ffc107; color: #000; font-size: 13px; border: none; border-radius: 4px; cursor: pointer; }
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
        <h2><?php echo !empty($id_editar) ? "Editar Livro / Gerenciar Estoque" : "Cadastrar Novo Livro"; ?></h2>

        <form action="processa_livro.php" method="POST">
            <input type="hidden" name="id_livro" value="<?php echo $id_editar; ?>">

            <div class="form-group">
                <label for="titulo_livro">Título do Livro:</label>
                <input type="text" name="titulo_livro" id="titulo_livro" value="<?php echo $titulo_editar; ?>" required>
            </div>

            <div class="form-group">
                <label for="autor_livro">Autor:</label>
                <input type="text" name="autor_livro" id="autor_livro" value="<?php echo $autor_editar; ?>" required>
            </div>

            <div class="form-group">
                <label for="id_genero">Gênero:</label>
                <select name="id_genero" id="id_genero" required>
                    <option value="">-- Selecione o Gênero --</option>
                    <?php if ($query_generos && mysqli_num_rows($query_generos) > 0): ?>
                        <?php while ($g = mysqli_fetch_assoc($query_generos)): ?>
                            <option value="<?php echo $g['id_genero']; ?>" <?php echo ($g['id_genero'] == $genero_editar) ? 'selected' : ''; ?>>
                                <?php echo $g['nome_genero']; ?>
                            </option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="quantidade_livro">Quantidade em Estoque:</label>
                <input type="number" name="quantidade_livro" id="quantidade_livro" min="0" value="<?php echo $quantidade_editar; ?>" required>
            </div>

            <button type="submit" name="btn_salvar_livro">Salvar Livro / Estoque</button>
        </form>
    </div>

    <h2>Acervo Cadastrado</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Gênero</th>
                <th>Estoque</th>
                <th>Situação</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_livros && mysqli_num_rows($result_livros) > 0): ?>
                <?php while ($l = mysqli_fetch_assoc($result_livros)): ?>
                    <tr>
                        <td><?php echo $l['id_livro']; ?></td>
                        <td><?php echo $l['titulo_livro']; ?></td>
                        <td><?php echo $l['autor_livro']; ?></td>
                        <td><?php echo $l['nome_genero'] ? $l['nome_genero'] : 'Sem Gênero'; ?></td>
                        <td><?php echo $l['quantidade_livro']; ?></td>
                        <td>
                            <?php 
                            if ($l['quantidade_livro'] > 0) {
                                echo "<strong style='color:green;'>Disponível</strong>";
                            } else {
                                echo "<strong style='color:red;'>Indisponível</strong>";
                            }
                            ?>
                        </td>
                        <td>
                            <form action="bibliotecaria_livros.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id_livro" value="<?php echo $l['id_livro']; ?>">
                                <button type="submit" name="btn_carregar_livro" class="btn-acao">Editar / Gerenciar Estoque</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Nenhum livro cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>