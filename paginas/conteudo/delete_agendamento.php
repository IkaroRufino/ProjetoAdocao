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

// Verifica se o ID do agendamento foi passado via GET
if (isset($_GET['id_agendoacao'])) {
    $id_agendamento = (int) $_GET['id_agendoacao'];

    // Conexão ao banco de dados (substitua pela sua conexão)
    try {

        // Consulta para deletar o agendamento
        $query = "DELETE FROM tb_agendoacao WHERE id_agendoacao = :id_agendamento";
        $stmt = $conect->prepare($query);
        $stmt->bindParam(':id_agendamento', $id_agendamento, PDO::PARAM_INT);

        // Executar a consulta
        if ($stmt->execute()) {
            // Redirecionar para a página de listagem após a exclusão
            header("Location: home.php?acao=listagemdoacoes");
            exit;
        } else {
            echo "Erro ao deletar o agendamento.";
        }
    } catch (PDOException $e) {
        echo "Erro de conexão ou SQL: " . $e->getMessage();
    }
} else {
    // Redirecionar de volta se o ID do agendamento não for passado
    header("Location: home.php?acao=ERROR");
    exit;
}
?>
