<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in (uncomment this if necessary)
//if (!isset($_SESSION['loginUser'])) {
//    header("Location: home.php?acao=login");
//    exit;
//}

// Check if 'id_animais' is provided in the URL
if (isset($_GET['id_animais'])) {
    $id_animais = (int) $_GET['id_animais'];

    // Fetch the animal details from the database
    try {
        // Prepare the SQL query to fetch animal details
        $query = "SELECT nome_animal, especie_animal, raca_animal, sexo_animal, data_nascimento, foto_animal 
                  FROM tb_animais 
                  WHERE id_animais = :id_animais";
        $stmt = $conect->prepare($query);
        $stmt->bindParam(':id_animais', $id_animais, PDO::PARAM_INT);
        $stmt->execute();
        
        $animal = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Check if the animal exists
        if ($animal) {
            // Calculate the animal's age from its birth date
            $data_nascimento = new DateTime($animal['data_nascimento']);
            $idade = $data_nascimento->diff(new DateTime())->y;

            // Store animal details in session
            $_SESSION['animal'] = $animal;
        } else {
            echo "Animal não encontrado.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Erro de PDO: " . $e->getMessage();
        exit;
    }
}
?>

<!-- Animal adoption page -->
<div class="containerAdote">
    <div class="form-image">
        <img src="../img/<?= htmlspecialchars($animal['foto_animal']); ?>" alt="Foto do animal">
    </div>

    <div class="form">
        <form action="#">
            <div class="form-header">
                <div class="title">
                    <h1>ADOTE-ME</h1>
                </div>
                <div class="login-button">
                    <button><a href="home.php?acao=proprietario">Adotar</a></button>
                </div>
            </div>

            <!-- Display the animal's details dynamically -->
            <div class="info-group">
                <div class="info-box">
                    <label><strong>Nome:</strong></label>
                    <p><?= htmlspecialchars($animal['nome_animal']); ?></p>
                </div>

                <div class="info-box">
                    <label><strong>Espécie:</strong></label>
                    <p><?= htmlspecialchars($animal['especie_animal']); ?></p>
                </div>

                <div class="info-box">
                    <label><strong>Raça:</strong></label>
                    <p><?= htmlspecialchars($animal['raca_animal']); ?></p>
                </div>

                <div class="info-box">
                    <label><strong>Sexo:</strong></label>
                    <p><?= htmlspecialchars($animal['sexo_animal']); ?></p>
                </div>

                <div class="info-box">
                    <label><strong>Idade:</strong></label>
                    <p><?= $idade; ?> anos</p>
                </div>

            </div>
        </form>
    </div>
</div>
