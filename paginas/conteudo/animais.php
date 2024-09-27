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

// Captura o ID do usuário da sessão (o doador do animal)
$id_usuario = $_SESSION['id_user'];

// Processar o formulário de cadastro de animais
if (isset($_POST['botao'])) {
    // Capturar os dados do formulário de cadastro de animais
    $nome_animal = $_POST['name'] ?? null;
    $especie = $_POST['especie'] ?? null;
    $raca = $_POST['raca'] ?? null;
    $idade = $_POST['idade'] ?? null;
    $sexo = $_POST['sexo'] ?? null;
    $data_nascimento = $_POST['data_nascimento'] ?? null;

    // Validar campos obrigatórios
    if (empty($nome_animal) || empty($especie) || empty($sexo)) {
        echo "Os campos Nome do Animal, Espécie e Sexo são obrigatórios.";
        return;
    }

    // Preparar o comando SQL para inserir os dados na tabela tb_animais
    $query = "INSERT INTO tb_animais (nome_animal, especie_animal, raca_animal, sexo_animal, data_nascimento) 
              VALUES (:nome_animal, :especie, :raca, :sexo, :data_nascimento)";
    
    try {
        // Preparar a declaração SQL
        $stmt = $conect->prepare($query);
        $stmt->bindParam(':nome_animal', $nome_animal, PDO::PARAM_STR);
        $stmt->bindParam(':especie', $especie, PDO::PARAM_STR);
        $stmt->bindParam(':raca', $raca, PDO::PARAM_STR);
        $stmt->bindParam(':sexo', $sexo, PDO::PARAM_STR);
        $stmt->bindParam(':data_nascimento', $data_nascimento, PDO::PARAM_STR);

        // Executar a consulta
        if ($stmt->execute()) {
            echo "Animal cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar o animal.";
        }
    } catch (PDOException $e) {
        echo "<strong>ERRO DE PDO: </strong>" . $e->getMessage();
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
        .containerAnimais {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
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
        button, textarea {
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
        }
        button[type="submit"]:hover {
            background-color: #F08080;
            color: white;
        }
    </style>
    <div class="containerAnimais">
        <h1>Cadastro de animais</h1>
        <form action="" method="post">
            <label for="name">Nome do animal:</label>
            <input type="text" id="name" name="name" required>

            <label for="especie">Espécie:</label>
            <input type="text" id="especie" name="especie"><br>

            <label for="raca">Raça:</label>
            <input type="text" id="raca" name="raca"><br>

            <label for="idade">Idade:</label>
            <input type="number" id="idade" name="idade" min="0"><br>

            <label for="sexo">Sexo:</label>
            <select id="sexo" name="sexo">

            <option value="M">Macho</option>
            <option value="F">Fêmea</option>
            </select><br>

            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" id="data_nascimento" name="data_nascimento"><br>
            <button type="submit" name="botao">Cadastrar</button>
        </form>
    </div>
