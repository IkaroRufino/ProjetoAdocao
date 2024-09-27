<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verify if the user is logged in
if (!isset($_SESSION['loginUser'])) {
    header("Location: ../login/login.php");
    exit;
}

// Capture the logged-in user's ID
$id_usuario = $_SESSION['id_user'];

// Define how many animals to show per page (default 8)
$limite = 8;

// Check if a specific page was set in the URL, otherwise default to page 1
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina - 1) * $limite;

// Capture the action from the URL (more secure sanitization)
$acao = filter_input(INPUT_GET, 'acao', FILTER_SANITIZE_STRING) ?? 'listaranimais';

try {
    // SQL query to count total number of animals for pagination
    $queryTotal = "SELECT COUNT(*) FROM tb_animais";
    $stmtTotal = $conect->prepare($queryTotal);
    $stmtTotal->execute();
    $totalAnimais = $stmtTotal->fetchColumn();

    // SQL query to fetch the paginated animal data
    $query = "SELECT id_animais, nome_animal, especie_animal, raca_animal, sexo_animal, data_nascimento 
              FROM tb_animais 
              LIMIT :limite OFFSET :offset";
    
    $result = $conect->prepare($query);
    $result->bindParam(':limite', $limite, PDO::PARAM_INT);
    $result->bindParam(':offset', $offset, PDO::PARAM_INT);
    $result->execute();
    
    $animais = $result->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<strong>ERRO DE PDO: </strong>" . $e->getMessage();
}

// Calculate total number of pages
$totalPaginas = ceil($totalAnimais / $limite);
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #ffffff;
        color: #333;
        margin: 0;
        padding: 0;
    }
    .container {
        width: 80%;
        margin: 0 auto;
        padding: 20px;
    }
    h1 {
        color: #F08080;
        text-align: center;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    table, th, td {
        border: 1px solid #ddd;
    }
    th, td {
        padding: 10px;
        text-align: left;
    }
    th {
        background-color: #F08080;
        color: white;
    }
    .pagination {
        text-align: center;
        margin-top: 20px;
    }
    .pagination a {
        color: #F08080;
        padding: 8px 16px;
        text-decoration: none;
        border: 1px solid #ddd;
        margin: 0 4px;
        display: inline-block;
    }
    .pagination a:hover {
        background-color: #ddd;
    }
    .pagination a.active {
        background-color: #F08080;
        color: white;
        border: 1px solid #F08080;
    }
    .pagination-container {
        margin-top: 20px;
    }
    .pagination a.disabled {
        pointer-events: none;
        background-color: #f1f1f1;
        color: #ccc;
        border: 1px solid #ccc;
    }
    .btn {
        padding: 6px 12px;
        margin-right: 5px;
        text-decoration: none;
        color: #fff;
        background-color: #5cb85c; /* Green for "Edit" */
        border-radius: 4px;
    }
    .btn.delete {
        background-color: #d9534f; /* Red for "Delete" */
    }
    .btn:hover {
        opacity: 0.9;
    }
    .btns {
        text-align: center;
    }
</style>

<div class="container">
    <h1>Lista de Animais</h1>
    <?php if (!empty($animais)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID do Animal</th>
                    <th>Nome</th>
                    <th>Espécie</th>
                    <th>Raça</th>
                    <th>Sexo</th>
                    <th>Data de Nascimento</th>
                    <th>Ações</th> <!-- New column for action buttons -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($animais as $animal): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($animal['id_animais']); ?></td>
                        <td><?php echo htmlspecialchars($animal['nome_animal']); ?></td>
                        <td><?php echo htmlspecialchars($animal['especie_animal']); ?></td>
                        <td><?php echo htmlspecialchars($animal['raca_animal']); ?></td>
                        <td><?php echo htmlspecialchars($animal['sexo_animal'] == 'M' ? 'Macho' : 'Fêmea'); ?></td>
                        <td><?php echo htmlspecialchars($animal['data_nascimento']); ?></td>
                        <td class="btns">
                            <!-- Buttons for editing and deleting -->
                            <a href="home.php?acao=editar&id_animais=<?php echo urlencode($animal['id_animais']); ?>" class="btn">Editar</a>
                            <a href="home.php?acao=excluir&id_animais=<?php echo urlencode($animal['id_animais']); ?>" class="btn delete" onclick="return confirm('Tem certeza que deseja deletar este animal?');">Deletar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum animal encontrado.</p>
    <?php endif; ?>
</div>

<!-- Pagination controls -->
<div class="pagination-container">
    <div class="pagination">
        <!-- Previous Button -->
        <a href="?acao=<?php echo htmlspecialchars($acao); ?>&pagina=<?php echo max(1, $pagina - 1); ?>" 
           class="<?php if ($pagina == 1) echo 'disabled'; ?>">
            Anterior
        </a>

        <!-- Page Numbers -->
        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <a href="?acao=<?php echo htmlspecialchars($acao); ?>&pagina=<?php echo $i; ?>" class="<?php if ($i == $pagina) echo 'active'; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <!-- Next Button -->
        <a href="?acao=<?php echo htmlspecialchars($acao); ?>&pagina=<?php echo min($totalPaginas, $pagina + 1); ?>" 
           class="<?php if ($pagina == $totalPaginas) echo 'disabled'; ?>">
            Próximo
        </a>
    </div>
</div>
