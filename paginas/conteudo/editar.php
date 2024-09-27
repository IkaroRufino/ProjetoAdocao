<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['loginUser'])) {
    header("Location: ../login/login.php");
    exit;
}

// Check if the edit action and animal ID are provided
if (isset($_GET['acao']) && $_GET['acao'] === 'editar' && isset($_GET['id_animais'])) {
    $id_animais = (int) $_GET['id_animais'];
    
    // Fetch the animal details from the database
    try {
        $query = "SELECT nome_animal, especie_animal, raca_animal, sexo_animal, data_nascimento, foto_animal 
                  FROM tb_animais 
                  WHERE id_animais = :id_animais";
        $stmt = $conect->prepare($query);
        $stmt->bindParam(':id_animais', $id_animais, PDO::PARAM_INT);
        $stmt->execute();
        
        $animal = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Check if the animal exists
        if ($animal) {
            // If the form is submitted
            if (isset($_POST['update'])) {
                $nome_animal = $_POST['nome_animal'] ?? null;
                $especie_animal = $_POST['especie_animal'] ?? null;
                $raca_animal = $_POST['raca_animal'] ?? null;
                $sexo_animal = $_POST['sexo_animal'] ?? null;
                $data_nascimento = $_POST['data_nascimento'] ?? null;
                
                // Validate required fields
                if (empty($nome_animal) || empty($especie_animal) || empty($sexo_animal)) {
                    echo "Os campos Nome, Espécie e Sexo são obrigatórios.";
                } else {
                    // Check if a new image is uploaded
                    $foto_animal = $animal['foto_animal']; // Keep current image by default
                    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
                        $imagem = $_FILES['imagem'];
                        $dir_upload = "../img/";

                        // Ensure the directory exists
                        if (!is_dir($dir_upload)) {
                            mkdir($dir_upload, 0755, true);
                        }

                        // Generate unique filename and path
                        $nome_arquivo = uniqid() . '-' . basename($imagem['name']);
                        $caminho_arquivo = $dir_upload . $nome_arquivo;

                        // Check if the file is an allowed image type
                        $extensao = strtolower(pathinfo($caminho_arquivo, PATHINFO_EXTENSION));
                        $tipos_permitidos = ['jpg', 'jpeg', 'png', 'gif'];
                        if (in_array($extensao, $tipos_permitidos)) {
                            if (move_uploaded_file($imagem['tmp_name'], $caminho_arquivo)) {
                                $foto_animal = $nome_arquivo; // Update with new image
                            } else {
                                echo "Erro ao fazer upload da imagem.";
                            }
                        } else {
                            echo "Formato de imagem inválido. Apenas JPG, JPEG, PNG e GIF são permitidos.";
                        }
                    }

                    // Update the animal details in the database
                    $queryUpdate = "UPDATE tb_animais 
                                    SET nome_animal = :nome_animal, 
                                        especie_animal = :especie_animal, 
                                        raca_animal = :raca_animal, 
                                        sexo_animal = :sexo_animal, 
                                        data_nascimento = :data_nascimento, 
                                        foto_animal = :foto_animal
                                    WHERE id_animais = :id_animais";
                    
                    $stmtUpdate = $conect->prepare($queryUpdate);
                    $stmtUpdate->bindParam(':nome_animal', $nome_animal, PDO::PARAM_STR);
                    $stmtUpdate->bindParam(':especie_animal', $especie_animal, PDO::PARAM_STR);
                    $stmtUpdate->bindParam(':raca_animal', $raca_animal, PDO::PARAM_STR);
                    $stmtUpdate->bindParam(':sexo_animal', $sexo_animal, PDO::PARAM_STR);
                    $stmtUpdate->bindParam(':data_nascimento', $data_nascimento, PDO::PARAM_STR);
                    $stmtUpdate->bindParam(':foto_animal', $foto_animal, PDO::PARAM_STR); // Update the image
                    $stmtUpdate->bindParam(':id_animais', $id_animais, PDO::PARAM_INT);
                    
                    // Execute the update query
                    if ($stmtUpdate->execute()) {
                        echo "Animal atualizado com sucesso!";
                        header("Location: home.php?acao=listagem");
                        exit;
                    } else {
                        echo "Erro ao atualizar o animal.";
                    }
                }
            }
        } else {
            echo "Animal não encontrado.";
        }
    } catch (PDOException $e) {
        echo "Erro de PDO: " . $e->getMessage();
    }
}
?>

<!-- HTML form to edit animal details -->
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

<!-- HTML form to edit animal details including image -->
<style>
    /* Styles omitted for brevity */
</style>

<div class="container">
    <h1>Editar Animal</h1>
    
    <?php if ($animal): ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="nome_animal">Nome do Animal:</label>
            <input type="text" id="nome_animal" name="nome_animal" value="<?php echo htmlspecialchars($animal['nome_animal']); ?>" required>
            
            <label for="especie_animal">Espécie:</label>
            <input type="text" id="especie_animal" name="especie_animal" value="<?php echo htmlspecialchars($animal['especie_animal']); ?>" required>
            
            <label for="raca_animal">Raça:</label>
            <input type="text" id="raca_animal" name="raca_animal" value="<?php echo htmlspecialchars($animal['raca_animal']); ?>">
            
            <label for="sexo_animal">Sexo:</label>
            <select id="sexo_animal" name="sexo_animal" required>
                <option value="M" <?php if ($animal['sexo_animal'] === 'M') echo 'selected'; ?>>Macho</option>
                <option value="F" <?php if ($animal['sexo_animal'] === 'F') echo 'selected'; ?>>Fêmea</option>
            </select>
            
            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" id="data_nascimento" name="data_nascimento" value="<?php echo htmlspecialchars($animal['data_nascimento']); ?>">

            <label for="imagem">Foto do Animal (Deixe em branco para manter a atual):</label>
            <input type="file" id="imagem" name="imagem" accept="image/*">
            
            <button type="submit" name="update">Atualizar</button>
        </form>
    <?php else: ?>
        <p>Animal não encontrado.</p>
    <?php endif; ?>
</div>
