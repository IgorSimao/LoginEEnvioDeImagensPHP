<?php

    $hostname = "localhost";
    $bancodedados = "upload";
    $usuario = "root";
    $senha = "";

    $mysqli = new mysqli($hostname,$usuario,$senha,$bancodedados);

    if($mysqli -> connect_error){
        echo("Erro ao estabelecer a conexão::".$mysqli->connect_error);
        exit();
    }
    //else{
    //     echo "Conectado ao Banco de Dados!";
    // }

?>