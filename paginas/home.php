<?php
// Incluir o header
include_once('../includes/header.php');

// Sanitizar e capturar a ação da URL
$acao = filter_var(isset($_GET['acao']) ? $_GET['acao'] : 'bemvindo', FILTER_SANITIZE_STRING);

// Definir as páginas disponíveis
$paginas = [
    'bemvindo' => 'conteudo/index.php',
    'ajudar' => 'conteudo/ajudar.php',
    'adocao' => 'conteudo/adocao.php',
    'animais' => 'conteudo/animais.php',
    'editar' => 'conteudo/editar.php',
    'editardoacoes' => 'conteudo/editardoacoes.php',  // Página de edição de agendamento
    'excluir' => 'conteudo/excluir.php',
    'delete' => 'conteudo/delete_agendamento.php',
    'listagem' => 'conteudo/listagem.php',
    'proprietario' => 'conteudo/proprietario.php',
    'doar' => 'conteudo/doar.php',
    'contatos' => 'conteudo/contato.php',
    'login' => '../login/login.php',
    'listagemdoacoes' => 'conteudo/listagemdoacoes.php',
    'modificar' => 'conteudo/modificar_agendamento.php',
    'proprietario' => 'conteudo/proprietario.php',
    'adote' => 'conteudo/adote.php',
    'contate' => 'conteudo/contate.php',
    'listagemadotantes' => 'conteudo/listagemadotantes.php',
    'deladot' => 'conteudo/deleteadotantes.php',
    'editadot' => 'conteudo/editadotantes.php',
];

if ($acao == 'editardoacoes') {
    // Capturar o ID do agendamento da URL
    $id_agendoacao = filter_input(INPUT_GET, 'id_agendoacao', FILTER_SANITIZE_NUMBER_INT);

    // Verificar se o ID do agendamento foi fornecido
    if ($id_agendoacao) {
        try {
            // Consulta SQL para buscar os dados do agendamento
            $queryEdit = "SELECT endereco_agendoacao, data_agendoacao, desc_agendoacao 
                          FROM tb_agendoacao 
                          WHERE id_agendoacao = :id_agendoacao";
            $stmtEdit = $conect->prepare($queryEdit);
            $stmtEdit->bindParam(':id_agendoacao', $id_agendoacao, PDO::PARAM_INT);
            $stmtEdit->execute();
            $agendamento = $stmtEdit->fetch(PDO::FETCH_ASSOC);

            if (!$agendamento) {
                echo "Agendamento não encontrado.";
                exit;
            }

            // Se o formulário de edição foi submetido
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Capturar os dados do formulário
                $endereco = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
                $data = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
                $descricao = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

                // Atualizar o agendamento no banco de dados
                $queryUpdate = "UPDATE tb_agendoacao 
                                SET endereco_agendoacao = :endereco, data_agendoacao = :data, desc_agendoacao = :descricao 
                                WHERE id_agendoacao = :id_agendoacao";
                $stmtUpdate = $conect->prepare($queryUpdate);
                $stmtUpdate->bindParam(':endereco', $endereco, PDO::PARAM_STR);
                $stmtUpdate->bindParam(':data', $data, PDO::PARAM_STR);
                $stmtUpdate->bindParam(':descricao', $descricao, PDO::PARAM_STR);
                $stmtUpdate->bindParam(':id_agendoacao', $id_agendoacao, PDO::PARAM_INT);
                $stmtUpdate->execute();

                echo "Agendamento atualizado com sucesso!";
                header("Location: home.php?acao=listagemdoacoes"); // Redireciona para a lista de agendamentos
                exit;
            }
        } catch (PDOException $e) {
            echo "<strong>ERRO DE PDO: </strong>" . $e->getMessage();
        }
    } else {
        echo "ID do agendamento inválido.";
        exit;
    }
}


// Verificar se a ação existe no array de páginas, caso contrário, redirecionar para 'bemvindo'
$pagina_incluir = isset($paginas[$acao]) ? $paginas[$acao] : $paginas['bemvindo'];

// Incluir a página correspondente à ação
include_once($pagina_incluir);

// Incluir o footer
include_once('../includes/footer.php');
?>
