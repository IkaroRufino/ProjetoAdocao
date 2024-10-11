<?php
// Iniciar a sessão
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o ID do animal foi passado
if (isset($_GET['id_animais'])) {
    $id_animais = (int) $_GET['id_animais'];

    // Consulta para buscar os detalhes do animal
    try {
        $query = "SELECT nome_animal, especie_animal, raca_animal, sexo_animal, data_nascimento, foto_animal 
                  FROM tb_animais 
                  WHERE id_animais = :id_animais";
        $stmt = $conect->prepare($query);
        $stmt->bindParam(':id_animais', $id_animais, PDO::PARAM_INT);
        $stmt->execute();
        
        $animal = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($animal) {
            // Calcular a idade do animal
            $data_nascimento = new DateTime($animal['data_nascimento']);
            $idade = $data_nascimento->diff(new DateTime())->y;

            // Armazenar os detalhes do animal e o ID do animal na sessão
            $_SESSION['animal'] = $animal;
            $_SESSION['id_animais'] = $id_animais; // Adicionar o ID do animal na sessão
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

<!-- Página de adoção com o formulário de detalhes -->
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

            <!-- Exibir os detalhes do animal -->
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
