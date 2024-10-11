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

// Captura o ID do agendamento a ser editado via URL
$id_agendamento = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_agendamento === 0) {
    echo "<p>Agendamento inválido.</p>";
    exit;
}

// Captura o ID do usuário da sessão
$id_usuario = $_SESSION['id_user'];

// Inicializar variáveis para os dados do agendamento
$endereco = $data = $descricao = "";

// Verifica se o formulário foi enviado para atualizar o agendamento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
    $data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING);
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);

    // Atualizar os dados no banco de dados
    if ($endereco && $data && $descricao) {
        $queryUpdate = "UPDATE tb_agendoacao 
                        SET endereco_agendoacao = :endereco, data_agendoacao = :data, desc_agendoacao = :descricao 
                        WHERE id_agendoacao = :id_agendamento AND id_user = :id_user";
        try {
            $stmt = $conect->prepare($queryUpdate);
            $stmt->bindParam(':endereco', $endereco, PDO::PARAM_STR);
            $stmt->bindParam(':data', $data, PDO::PARAM_STR);
            $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
            $stmt->bindParam(':id_agendamento', $id_agendamento, PDO::PARAM_INT);
            $stmt->bindParam(':id_user', $id_usuario, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "<p>Agendamento atualizado com sucesso!</p>";
            } else {
                echo "<p>Erro ao atualizar o agendamento.</p>";
            }
        } catch (PDOException $e) {
            echo "<strong>ERRO DE PDO: </strong>" . $e->getMessage();
        }
    } else {
        echo "<p>Preencha todos os campos corretamente.</p>";
    }
} else {
    // Carregar os dados atuais do agendamento
    try {
        $query = "SELECT * FROM tb_agendoacao WHERE id_agendoacao = :id_agendamento AND id_user = :id_user";
        $stmt = $conect->prepare($query);
        $stmt->bindParam(':id_agendamento', $id_agendamento, PDO::PARAM_INT);
        $stmt->bindParam(':id_user', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $agendamento = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($agendamento) {
            $endereco = $agendamento['endereco_agendoacao'];
            $data = $agendamento['data_agendoacao'];
            $descricao = $agendamento['desc_agendoacao'];
        } else {
            echo "<p>Agendamento não encontrado ou você não tem permissão para editá-lo.</p>";
            exit;
        }
    } catch (PDOException $e) {
        echo "<strong>ERRO DE PDO: </strong>" . $e->getMessage();
        exit;
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
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #F08080;
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
        input[type="text"], input[type="date"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        button[type="submit"] {
            background-color: white;
            color: #F08080;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 10px;
            border-radius: 5px;
        }
        button[type="submit"]:hover {
            background-color: #F08080;
            color: white;
        }
    </style>
    <div class="container">
        <h1>Modificar Agendamento</h1>
        <form method="POST" action="">
            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" value="<?php echo htmlspecialchars($endereco); ?>" required>

            <label for="data">Data da Doação:</label>
            <input type="date" id="data" name="data" value="<?php echo htmlspecialchars($data); ?>" required>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="4" required><?php echo htmlspecialchars($descricao); ?></textarea>

            <button type="submit">Atualizar Agendamento</button>
        </form>
    </div>