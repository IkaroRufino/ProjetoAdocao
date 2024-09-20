<!DOCTYPE html>
<html lang="pr_br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../home.css">
    <title>ProjetoAdoção</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    include_once('../config/conexao.php');
    ?>
    <section class="header">
        <header>
            <a href="#"><img src="img/logo.png" alt="" class="logo"></a>
            <nav class="navegation">
                <ul>
                    <li><a href="../paginas/home.php?acao=bemvindo">Home</a></li>
                    <li><a href="../paginas/home.php?acao=ajudar">Quero ajudar</a></li>
                    <li><a href="../paginas/home.php?acao=adocao">Animais para adoção</a></li>
                    <li><a href="../paginas/home.php?acao=contatos">Sobre nós</a></li>
                </ul>
            </nav>
        </header>
    </section>