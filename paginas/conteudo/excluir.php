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
if (isset($_GET['id_animais'])) {
    $id_animais = (int) $_GET['id_animais'];

    try {

        // Consulta para deletar o agendamento
        $query = "DELETE FROM tb_animais WHERE id_animais = :id_animais";
        $stmt = $conect->prepare($query);
        $stmt->bindParam(':id_animais', $id_animais, PDO::PARAM_INT);

        // Executar a consulta
        if ($stmt->execute()) {
            // Redirecionar para a página de listagem após a exclusão
            header("Location: home.php?acao=listagem");
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
