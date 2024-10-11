<?php
// Iniciar a sessão
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar se o usuário está logado
if (!isset($_SESSION['id_user'])) {
    header("Location: home.php?acao=login");
    exit();
}

// Captura o ID do adotante a ser editado
$id_adotante = filter_input(INPUT_GET, 'id_adotante', FILTER_SANITIZE_NUMBER_INT);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coletar os dados do formulário
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $endereco = trim($_POST['endereco']);
    $telefone = trim($_POST['telefone']);

    // Atualizar o adotante no banco de dados
    $query = "UPDATE tb_adotante SET nome_adotante = :nome, email_adotante = :email, endereco_adotante = :endereco, telefone_adotante = :telefone
              WHERE id_adotante = :id_adotante";
    $stmt = $conect->prepare($query);
    // Vincular parâmetros
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':id_adotante', $id_adotante, PDO::PARAM_INT);
    if ($stmt->execute()) {
        // Redirecionar para a página principal após a edição
        header("Location: home.php?acao=listagemadotantes");
        exit();
    } else {
        echo "Erro ao atualizar o adotante.";
    }
} else {
    // Exibir os dados atuais do adotante para edição
    $query = "SELECT * FROM tb_adotante WHERE id_adotante = :id_adotante";
    $stmt = $conect->prepare($query);
    $stmt->bindParam(':id_adotante', $id_adotante, PDO::PARAM_INT);
    $stmt->execute();
    $adotante = $stmt->fetch(PDO::FETCH_ASSOC);
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
        color: #F08080;
        margin-bottom: 10px;
    }
    input, select, button {
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

<div class="container">
    <h1>Editar Adotante</h1>

    <?php if ($adotante): ?>
        <form action="" method="post">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($adotante['nome_adotante']); ?>" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($adotante['email_adotante']); ?>" required><br>

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" value="<?php echo htmlspecialchars($adotante['endereco_adotante']); ?>" required><br>

            <label for="endereco">Telefone:</label>
            <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($adotante['telefone_adotante']); ?>" required><br>

            <input type="submit" value="Atualizar">
        </form>
    <?php else: ?>
        <p>Adotante não encontrado.</p>
    <?php endif; ?>
</div>
