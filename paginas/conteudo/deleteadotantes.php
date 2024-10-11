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

// Verifica se o ID do adotante foi passado via GET
if (isset($_GET['id_adotante'])) {
    $id_adotante = (int) $_GET['id_adotante'];

    // Conexão ao banco de dados (substitua pela sua conexão)
    try {
        // Crie sua conexão aqui, por exemplo:
        // $conect = new PDO("mysql:host=localhost;dbname=bd_adocaoPet", "root", "");

        // Consulta para deletar o adotante
        $query = "DELETE FROM tb_adotante WHERE id_adotante = :id_adotante";
        $stmt = $conect->prepare($query);
        $stmt->bindParam(':id_adotante', $id_adotante, PDO::PARAM_INT);

        // Executar a consulta
        if ($stmt->execute()) {
            // Redirecionar para a página de listagem após a exclusão
            header("Location: home.php?acao=listagemadotantes");
            exit;
        } else {
            echo "Erro ao deletar o adotante.";
        }
    } catch (PDOException $e) {
        echo "Erro de conexão ou SQL: " . $e->getMessage();
    }
} else {
    // Redirecionar de volta se o ID do adotante não for passado
    header("Location: home.php?acao=ERROR");
    exit;
}
?>
