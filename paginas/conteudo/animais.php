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
    $sexo = $_POST['sexo'] ?? null;
    $data_nascimento = $_POST['data_nascimento'] ?? null;

    // Validar campos obrigatórios
    if (empty($nome_animal) || empty($especie) || empty($sexo)) {
        echo "Os campos Nome do Animal, Espécie e Sexo são obrigatórios.";
        return;
    }

    // Verificar se um arquivo de imagem foi enviado
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $imagem = $_FILES['imagem'];

        // Definir o diretório de upload
        $dir_upload = "../img/";

        // Verificar se o diretório existe, se não, criar
        if (!is_dir($dir_upload)) {
            mkdir($dir_upload, 0755, true);
        }

        // Gerar um nome único para a imagem para evitar conflitos
        $nome_arquivo = uniqid() . '-' . basename($imagem['name']);
        $caminho_arquivo = $dir_upload . $nome_arquivo;

        // Verificar se o arquivo é uma imagem válida
        $extensao = strtolower(pathinfo($caminho_arquivo, PATHINFO_EXTENSION));
        $tipos_permitidos = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($extensao, $tipos_permitidos)) {
            // Mover o arquivo para o diretório de uploads
            if (move_uploaded_file($imagem['tmp_name'], $caminho_arquivo)) {
                // Preparar o comando SQL para inserir os dados na tabela tb_animais
                $query = "INSERT INTO tb_animais (nome_animal, especie_animal, raca_animal, sexo_animal, data_nascimento, foto_animal) 
                          VALUES (:nome_animal, :especie, :raca, :sexo, :data_nascimento, :foto_animal)";
                
                try {
                    // Preparar a declaração SQL
                    $stmt = $conect->prepare($query);
                    $stmt->bindParam(':nome_animal', $nome_animal, PDO::PARAM_STR);
                    $stmt->bindParam(':especie', $especie, PDO::PARAM_STR);
                    $stmt->bindParam(':raca', $raca, PDO::PARAM_STR);
                    $stmt->bindParam(':sexo', $sexo, PDO::PARAM_STR);
                    $stmt->bindParam(':data_nascimento', $data_nascimento, PDO::PARAM_STR);
                    $stmt->bindParam(':foto_animal', $nome_arquivo, PDO::PARAM_STR); // Salvar o nome do arquivo de imagem

                    // Executar a consulta
                    if ($stmt->execute()) {
                        echo "Animal cadastrado com sucesso!";
                    } else {
                        echo "Erro ao cadastrar o animal.";
                    }
                } catch (PDOException $e) {
                    echo "<strong>ERRO DE PDO: </strong>" . $e->getMessage();
                }
            } else {
                echo "Erro ao fazer upload da imagem.";
            }
        } else {
            echo "Formato de imagem inválido. Apenas JPG, JPEG, PNG e GIF são permitidos.";
        }
    } else {
        echo "Nenhuma imagem foi enviada ou houve um erro no upload.";
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
        <form action="" method="post" enctype="multipart/form-data">
            <label for="name">Nome do animal:</label>
    <input type="text" id="name" name="name" required>

            <label for="especie">Espécie:</label>
    <input type="text" id="especie" name="especie"><br>

    <label for="raca">Raça:</label>
    <input type="text" id="raca" name="raca"><br>

    <label for="sexo">Sexo:</label>
    <select id="sexo" name="sexo">
        <option value="M">Macho</option>
        <option value="F">Fêmea</option>
    </select><br>

    <label for="data_nascimento">Data de Nascimento:</label>
    <input type="date" id="data_nascimento" name="data_nascimento"><br>

    <label for="imagem">Foto do Animal:</label>
    <input type="file" id="imagem" name="imagem" accept="image/*" required><br>

    <button type="submit" name="botao">Cadastrar</button>
</form>
    </div>
