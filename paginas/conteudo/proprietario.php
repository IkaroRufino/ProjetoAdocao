<?php
// Iniciar a sessão no início do arquivo
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está logado
if (!isset($_SESSION['loginUser'])) {
    header("Location: home.php?acao=login");
    exit;
}

// Capturar o ID do usuário e do animal da sessão
$id_user = $_SESSION['loginUser']; // ID do usuário logado
$id_animais = $_SESSION['id_animais']; // ID do animal que foi selecionado para adoção

// Inicializar variável de mensagem vazia
$message = '';

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coletar dados do formulário
    $nome = trim($_POST['nome']);
    $endereco = trim($_POST['endereco']);
    $telefone = trim($_POST['telefone']);
    $email = trim($_POST['email']);

    // Validar se todos os campos estão preenchidos
    if (empty($nome) || empty($endereco) || empty($telefone) || empty($email)) {
        $message = "Todos os campos são obrigatórios.";
    } else {
        // Inserir dados na tabela tb_adotante e deletar o animal após o cadastro
        try {
            // Inserir adotante no banco de dados
            $queryAdotante = "INSERT INTO tb_adotante (nome_adotante, endereco_adotante, telefone_adotante, email_adotante, id_user)
                              VALUES (:nome, :endereco, :telefone, :email, :id_user)";
            $stmtAdotante = $conect->prepare($queryAdotante);
            $stmtAdotante->bindParam(':nome', $nome);
            $stmtAdotante->bindParam(':endereco', $endereco);
            $stmtAdotante->bindParam(':telefone', $telefone);
            $stmtAdotante->bindParam(':email', $email);
            $stmtAdotante->bindParam(':id_user', $id_user, PDO::PARAM_INT);

            // Executar a inserção
            if ($stmtAdotante->execute()) {
                // Deletar o animal correspondente
                $queryDeleteAnimal = "DELETE FROM tb_animais WHERE id_animais = :id_animais";
                $stmtDelete = $conect->prepare($queryDeleteAnimal);
                $stmtDelete->bindParam(':id_animais', $id_animais, PDO::PARAM_INT);
                $stmtDelete->execute();

                // Redirecionar para a página de contato após o cadastro bem-sucedido
                header("Location: home.php?acao=contate");
                exit(); // Garantir que nenhum código adicional seja executado
            } else {
                $message = "Ocorreu um erro ao tentar cadastrar o adotante.";
            }
        } catch (PDOException $e) {
            $message = "Erro de conexão: " . $e->getMessage();
        }
    }
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
        .containerP {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            flex: 1;
        }
        h1 {
            color: #F08080;
            text-align: center;
        }
        form {
            background-color: #F08080;
            padding: 20px;
            border-radius: 5px;
            color: white;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        input[type="submit"] {
            background-color: white;
            color: #F08080;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #F08080;
            color: white;
        }
        .message {
            color: green;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .error {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        </style>
    <!-- Formulário de cadastro com estilos -->
<div class="containerP">
    <h1>Cadastro do Proprietário</h1>

    <!-- Exibir mensagem de sucesso ou erro -->
    <?php if (!empty($message)): ?>
        <div class="<?= strpos($message, 'sucesso') !== false ? 'message' : 'error' ?>">
            <?= htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Formulário de cadastro do proprietário -->
    <form action="" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br>

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" required><br>

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <input type="submit" value="Cadastrar">
    </form>
</div>