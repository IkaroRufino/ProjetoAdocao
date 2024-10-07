<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in (adjust based on your session logic)
//if (!isset($_SESSION['loginUser'])) {
    //header("Location: home.php?acao=login");
    //exit;
//}

$id_user = $_SESSION['loginUser']; // Assuming this stores the logged-in user's ID

// Initialize an empty message variable
$message = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $nome = trim($_POST['nome']);
    $endereco = trim($_POST['endereco']);
    $telefone = trim($_POST['telefone']);
    $email = trim($_POST['email']);

    // Validate that none of the fields are empty
    if (empty($nome) || empty($endereco) || empty($telefone) || empty($email)) {
        $message = "Todos os campos são obrigatórios.";
    } else {
        // Insert data into the database
        try {
            // Prepare the SQL query
            $query = "INSERT INTO tb_adotantes (nome_adotante, endereco_adotante, telefone_adotante, email_adotante, id_user)
                      VALUES (:nome, :endereco, :telefone, :email, :id_user)";
            
            $stmt = $conect->prepare($query);

            // Bind parameters
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':endereco', $endereco);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);

            // Execute the query
            if ($stmt->execute()) {
                // Redirect to contact page after successful registration
                header("Location: home.php?acao=contate");
                exit(); // Ensure no further code is executed
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
    <div class="containerP">
        <h1>Cadastro do Proprietário</h1>

        <!-- Display success or error message -->
        <?php if (!empty($message)): ?>
            <div class="<?= strpos($message, 'sucesso') !== false ? 'message' : 'error' ?>">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- Registration form -->
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