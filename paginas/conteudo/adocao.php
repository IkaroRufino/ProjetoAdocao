<?php
// Iniciar a sessão no início do arquivo
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se a ação foi definida na URL (sanitização mais segura)
$acao = filter_input(INPUT_GET, 'acao', FILTER_SANITIZE_STRING) ?? 'bemvindo';

// Limites para paginação (opcional)
$limite = 10;  // Número de registros por página
$offset = 0;   // Página inicial, pode ser modificado conforme a paginação

try {
    // Consulta SQL para buscar animais incluindo a foto (foto_animal)
    $query = "SELECT a.nome_animal, a.especie_animal, a.raca_animal, a.sexo_animal, a.data_nascimento, a.foto_animal
              FROM tb_animais a
              LIMIT :limite OFFSET :offset";
    
    $result = $conect->prepare($query);
    $result->bindParam(':limite', $limite, PDO::PARAM_INT);
    $result->bindParam(':offset', $offset, PDO::PARAM_INT);
    $result->execute();
    
    $animais = $result->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<strong>ERRO DE PDO: </strong>" . $e->getMessage();
}
?>

<section class="conteudo">
    <div class="contentadocao">
        <div class="text">
            <h2><br><span>Encontre seu novo amigo</span></h2>
            <h3><p class="h3txt">Adote um animal e descubra a alegria de ter um amigo leal que transformará sua vida com amor incondicional!</p></h3>
            
            <section id="gallery" class="animal-gallery">
                <h2>Animais Disponíveis para Adoção</h2>
                <div class="containerAdocao">
                    <?php if (!empty($animais)): ?>
                        <?php foreach ($animais as $animal): ?>
                            <div class="animal-item">
                                <?php if (!empty($animal['foto_animal']) && file_exists('../img/' . $animal['foto_animal'])): ?>
                                    <!-- Mostrar a imagem do animal se existir -->
                                    <img src="../img/<?= htmlspecialchars($animal['foto_animal']) ?>" alt="<?= htmlspecialchars($animal['nome_animal']) ?>">
                                <?php else: ?>
                                    <!-- Mostrar um fallback caso a imagem não exista -->
                                    <img src="../img/default-placeholder.jpg" alt="<?= htmlspecialchars($animal['nome_animal']) ?>">
                                <?php endif; ?>
                                
                                <h3><?= htmlspecialchars($animal['nome_animal']) ?></h3>
                                <p><strong>Espécie:</strong> <?= htmlspecialchars($animal['especie_animal']) ?></p>
                                <p><strong>Raça:</strong> <?= htmlspecialchars($animal['raca_animal']) ?></p>
                                <p><strong>Sexo:</strong> <?= htmlspecialchars($animal['sexo_animal']) == 'M' ? 'Macho' : 'Fêmea' ?></p>
                                <p><strong>Idade:</strong> 
                                    <?php 
                                    // Calcular a idade do animal com base na data de nascimento
                                    $nascimento = new DateTime($animal['data_nascimento']);
                                    $hoje = new DateTime();
                                    $idade = $hoje->diff($nascimento)->y;
                                    echo $idade . ' anos';
                                    ?>
                                </p>
                               <a href="home.php?acao=proprietario"><button class="adopt-button">Adotar</button></a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhum animal disponível no momento.</p>
                    <?php endif; ?>
                </div>
                <div class="offer-pet">
                    <h3>Tem um animal para adoção?</h3>
                    <p>Se você deseja oferecer um animal para adoção, clique no botão abaixo:</p>
                    <a href="home.php?acao=animais" class="offer-button">Cadastrar Animal</a>
                </div>
            </section>
        </div>
    </div>
</section>
