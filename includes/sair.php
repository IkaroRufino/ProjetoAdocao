<?php

if(isset($_REQUEST['sair'])){
    session_destroy();
    header("Location: ../login/login.php");
}