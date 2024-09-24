<?php
include_once('../config/conexao.php');
////quando apertar o botão de criar conta: (lembrar de mudar esse submit depois)
//if(isset($_POST['submit']))
//    {
//        $nome = $_POST['nomeC'];
//        $email = $_POST['emailC'];
//        $senha = $_POST['senha'];
//        //escrever a query depois
//        $result = 
//
//        //recarregar a pagina após enviar os dados
//    }
?>
<div class="loginpage">
<div class="container" id="container">
        <div class="form-container sign-up">
            <form action="" method="POST">
                <h1>Crie uma conta</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>ou use seu e-mail para cadastro</span>
                <input type="text" name="nomeC" placeholder="Nome">
                <input type="email" name="emailC" placeholder="Email">
                <input type="password" name="senhaC" placeholder="Senha">
                <button>inscreva-se</button>
            </form>
        </div>
        <?php
//        if(isset($_POST['emailL']) || isset($_POST['senhaL'])) {
//
//            if(strlen($_POST['emailL']) == 0) {
//                echo "Preencha seu e-mail";
//            } else if(strlen($_POST['senhaL']) == 0) {
//                echo "Preencha sua senha";
//            } else {
//
//                $email = $conect->real_escape_string($_POST['emailL']);
//                $senha = $conect->real_escape_string($_POST['senhaL']);
//
//                $sql_code = "SELECT * FROM tb_user WHERE email_user = '$email' AND senha_user = '$senha'";
//                $sql_query = $conect->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
//
//                $quantidade = $sql_query->num_rows;
//
//                if($quantidade == 1) {
//            
//                    $usuario = $sql_query->fetch_assoc();
//
//                    if(!isset($_SESSION)) {
//                        session_start();
//                    }
//
//                    $_SESSION['id'] = $usuario['id'];
//                    $_SESSION['nome'] = $usuario['nome'];
//
//                    header("Location: ../paginas/home.php");
//
//                } else {
//                    echo "Falha ao logar! E-mail ou senha incorretos";
//                }
//
//            }
//
//        }
        ?>
        <div class="form-container sign-in">
            <form action="" method="POST">
                <h1>Entrar</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>ou use sua senha de e-mail</span>
                <input type="email" name="emailL" placeholder="Email">
                <input type="password" name="senhaL" placeholder="Senha">
                <a href="#">Esqueceu sua senha?</a>
                <button type="submit" name="botao">Entrar</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Bem-vindo de volta</h1>
                    <p>Insira seus dados pessoais para usar todos os recursos do site</p>
                    <button class="hidden" id="login">Entrar</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Olá amigo</h1>
                    <p>Insira seus dados pessoais para usar todos os recursos do site</p>
                    <button class="hidden" id="register">inscreva-se</button>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="../login/script.js"></script>