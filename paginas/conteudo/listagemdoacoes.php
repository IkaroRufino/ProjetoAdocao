<?php
// Iniciar a sessão no início do arquivo
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está logado
if (!isset($_SESSION['loginUser'])) {
    header("Location: ../login/login.php");
    exit;
}

// Captura o ID do usuário da sessão
$id_usuario = $_SESSION['id_user'];

// Definir quantos agendamentos serão mostrados por página (agora 5)
$limite = 6;

// Verifica se a página foi definida na URL, caso contrário, usa a página 1
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina - 1) * $limite;

// Verifica se a ação foi definida na URL (para os redirecionamentos corretos)
$acao = filter_var(isset($_GET['acao']) ? $_GET['acao'] : 'bemvindo', FILTER_SANITIZE_STRING);

try {
    // Consulta SQL para contar o total de agendamentos
    $queryTotal = "SELECT COUNT(*) FROM tb_agendoacao WHERE id_user = :id_user";
    $stmtTotal = $conect->prepare($queryTotal);
    $stmtTotal->bindParam(':id_user', $id_usuario, PDO::PARAM_INT);
    $stmtTotal->execute();
    $totalAgendamentos = $stmtTotal->fetchColumn();

    // Consulta SQL para buscar agendamentos com paginação (LIMIT e OFFSET)
    $query = "SELECT a.endereco_agendoacao, a.data_agendoacao, a.desc_agendoacao, u.id_user, u.nome_user 
              FROM tb_agendoacao a 
              JOIN tb_user u ON a.id_user = u.id_user 
              WHERE a.id_user = :id_user 
              LIMIT :limite OFFSET :offset";
    
    $result = $conect->prepare($query);
    $result->bindParam(':id_user', $id_usuario, PDO::PARAM_INT);
    $result->bindParam(':limite', $limite, PDO::PARAM_INT);
    $result->bindParam(':offset', $offset, PDO::PARAM_INT);
    $result->execute();
    
    $agendamentos = $result->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<strong>ERRO DE PDO: </strong>" . $e->getMessage();
}

// Calcular o número total de páginas
$totalPaginas = ceil($totalAgendamentos / $limite);
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
</style>

<div class="container">
    <h1>Lista de Agendamentos</h1>
    <?php if (!empty($agendamentos)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID do Usuário</th>
                    <th>Nome do Usuário</th>
                    <th>Endereço</th>
                    <th>Data da Doação</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($agendamentos as $agendamento): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($agendamento['id_user']); ?></td>
                        <td><?php echo htmlspecialchars($agendamento['nome_user']); ?></td>
                        <td><?php echo htmlspecialchars($agendamento['endereco_agendoacao']); ?></td>
                        <td><?php echo htmlspecialchars($agendamento['data_agendoacao']); ?></td>
                        <td><?php echo htmlspecialchars($agendamento['desc_agendoacao']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum agendamento encontrado.</p>
    <?php endif; ?>
</div>

<!-- Paginação fora do container -->
<div class="pagination-container">
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <a href="?acao=<?php echo htmlspecialchars($acao); ?>&pagina=<?php echo $i; ?>" class="<?php if ($i == $pagina) echo 'active'; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>
</div>

