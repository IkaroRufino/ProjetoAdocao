<?php
//// Inicia a sessão se ainda não foi iniciada
//if (session_status() == PHP_SESSION_NONE) {
//    session_start();
//}
//
//// Verifica se o usuário está logado
//if (!isset($_SESSION['id'])) {
//    header("Location: ../login/login.php");
//    exit;
//}

try {
    // Consulta SQL com JOIN para buscar agendamentos junto com o nome e ID do usuário
    $query = "SELECT a.endereco_agendoacao, a.data_agendoacao, a.desc_agendoacao, u.id_user, u.nome_user FROM tb_agendoacao a JOIN tb_user u ON a.id_user = u.id_user WHERE a.id_user = :id_user";
    
    $result = $conect->prepare($query);
    $result->bindParam(':id_user', $_SESSION['id'], PDO::PARAM_INT);
    $result->execute();
    
    $agendamentos = $result->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<strong>ERRO DE PDO: </strong>" . $e->getMessage();
}
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
