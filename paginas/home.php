<?php
include_once('../includes/header.php');

$acao = filter_var(isset($_GET['acao']) ? $_GET['acao'] : 'bemvindo', FILTER_SANITIZE_STRING);

$paginas = [
    'bemvindo' => 'conteudo/index.php',
    'ajudar' => 'conteudo/ajudar.php',
    'adocao' => 'conteudo/adocao.php',
    'animais' => 'conteudo/animais.php',
    'editar' => 'conteudo/editar.php',
    'excluir' => 'conteudo/excluir.php',
    'listagem' => 'conteudo/listagem.php',
    'proprietario' => 'conteudo/proprietario.php',
    'doar' => 'conteudo/doar.php',
    'contatos' => 'conteudo/contato.php',
    'login' => '../login/login.php',
    'listagemdoacoes' => 'conteudo/listagemdoacoes.php',
];

$pagina_incluir = isset($paginas[$acao]) ? $paginas[$acao] : $paginas['bemvindo'];

include_once($pagina_incluir);

include_once('../includes/footer.php');