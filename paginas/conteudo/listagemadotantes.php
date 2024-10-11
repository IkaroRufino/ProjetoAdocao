<?php  
// Iniciar a sessão no início do arquivo
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está logado
//if (!isset($_SESSION['loginUser'])) {
    //header("Location: home.php?acao=login");
    //exit;
//}

// Captura o ID do usuário da sessão
$id_usuario = $_SESSION['id_user'];

// Definir quantos adotantes serão mostrados por página (agora 8)
$limite = 8;

// Verifica se a página foi definida na URL, caso contrário, usa a página 1
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina - 1) * $limite;

// Verifica se a ação foi definida na URL (sanitização mais segura)
$acao = filter_input(INPUT_GET, 'acao', FILTER_SANITIZE_STRING) ?? 'bemvindo';

try {
    // Consulta SQL para contar o total de adotantes
    $queryTotal = "SELECT COUNT(*) FROM tb_adotante";
    $stmtTotal = $conect->prepare($queryTotal);
    $stmtTotal->execute();
    $totalAdotantes = $stmtTotal->fetchColumn();

    // Consulta SQL para buscar adotantes com paginação (LIMIT e OFFSET)
    $query = "SELECT id_adotante, nome_adotante, email_adotante, endereco_adotante 
              FROM tb_adotante 
              LIMIT :limite OFFSET :offset";
    
    $result = $conect->prepare($query);
    $result->bindParam(':limite', $limite, PDO::PARAM_INT);
    $result->bindParam(':offset', $offset, PDO::PARAM_INT);
    $result->execute();
    
    $adotantes = $result->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<strong>ERRO DE PDO: </strong>" . $e->getMessage();
}

// Calcular o número total de páginas
$totalPaginas = ceil($totalAdotantes / $limite);
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
        background-color: #5cb85c; /* Verde padrão para "Editar" */
        border-radius: 4px;
    }
    .btn.delete {
        background-color: #d9534f; /* Vermelho para "Deletar" */
    }
    .btn:hover {
        opacity: 0.9;
    }
    .btns{
        text-align: center;
    }
</style>

<div class="container">
    <h1>Lista de Adotantes</h1>
    <?php if (!empty($adotantes)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID do Adotante</th>
                    <th>Nome do Adotante</th>
                    <th>Email</th>
                    <th>Endereço</th>
                    <th>Ações</th> <!-- Nova coluna para os botões -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($adotantes as $adotante): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($adotante['id_adotante']); ?></td>
                        <td><?php echo htmlspecialchars($adotante['nome_adotante']); ?></td>
                        <td><?php echo htmlspecialchars($adotante['email_adotante']); ?></td>
                        <td><?php echo htmlspecialchars($adotante['endereco_adotante']); ?></td>
                        <td class="btns">
                            <!-- Botões de Editar e Deletar -->
                            <a href="home.php?acao=editaradotantes&id_adotante=<?php echo urlencode($adotante['id_adotante']); ?>" class="btn">Editar</a>
                            <a href="home.php?acao=delete&id_adotante=<?php echo urlencode($adotante['id_adotante']); ?>" class="btn delete" onclick="return confirm('Tem certeza que deseja deletar este adotante?');">Deletar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum adotante encontrado.</p>
    <?php endif; ?>
</div>

<!-- Paginação fora do container -->
<div class="pagination-container">
    <div class="pagination">
        <!-- Botão Anterior -->
        <a href="?acao=<?php echo htmlspecialchars($acao); ?>&pagina=<?php echo max(1, $pagina - 1); ?>" 
           class="<?php if ($pagina == 1) echo 'disabled'; ?>">
            Anterior
        </a>

        <!-- Paginação de números -->
        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <a href="?acao=<?php echo htmlspecialchars($acao); ?>&pagina=<?php echo $i; ?>" class="<?php if ($i == $pagina) echo 'active'; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <!-- Botão Próximo -->
        <a href="?acao=<?php echo htmlspecialchars($acao); ?>&pagina=<?php echo min($totalPaginas, $pagina + 1); ?>" 
           class="<?php if ($pagina == $totalPaginas) echo 'disabled'; ?>">
            Próximo
        </a>
    </div>
</div>
