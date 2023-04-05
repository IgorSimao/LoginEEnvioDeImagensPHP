<?php

include("conexaoBd.php");
session_start();
    if(isset($_SESSION['id_usuario']) && isset($_SESSION['nome_usuario']) && isset($_SESSION['permissao_usuario'])){
        global $permissao;
        $permissao = $_SESSION['permissao_usuario'];

        if(isset($_GET['deletar'])){
            $id = intval($_GET['deletar']);
        
            $sqlQuery = $mysqli->query("SELECT * from arquivos WHERE id='$id'") or die($mysqli->error);
        
            $arquivo = $sqlQuery->fetch_assoc();
            if(unlink($arquivo['path'])){
                $sucess = $mysqli->query("DELETE FROM arquivos WHERE id='$id'");
                if($sucess){
                    echo "<p>Arquivo removido com sucesso!</p>";
                }else{
                    echo "<p>Erro ao remover arquivo!</p>";
                }
            }
    }

}


function enviarImagens($error, $size, $nome, $tmp_name)
{
    include("conexaoBd.php");

    if ($error)
        die("Não foi possível enviar o arquivo!");

    if ($size > 2097152)
        die("Error: Arquivo muito grande, envie arquivos de até 2MBs!");

    $pasta = "arquivos/";

    $nomeArquivo = $nome;

    //Gerar identificador único

    $nomeUnicoArquivo = uniqid();

    ///Pegando a extensão do arquivo

    $extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));

    if ($extensao != 'jpg' && $extensao != 'jpeg' && $extensao != 'png') {
        die("Tipo de arquivo não suportado!");
    }

    ///Montando o path
    $path = $pasta . $nomeUnicoArquivo . "." . $extensao;

    $sucess = move_uploaded_file($tmp_name, $path);

    if ($sucess) {

        $mysqli->query("INSERT INTO arquivos(nome, path) VALUES('$nomeArquivo','$path')") or die($mysqli->error);
        // echo "Arquivo enviado com sucesso! <br>
        // Para acessar <a target='_blank' href='$path'> clique aqui!</a>";
        return true;

    } else {
        echo "Ocorreu um erro ao enviar o arquivo!";
        return false;
    }
}

if (isset($_FILES['arquivo'])) {
    //var_dump($_FILES['arquivo']);
    $arquivos = $_FILES['arquivo'];
    $erros = 0;
    foreach($arquivos['name'] as $index => $arq){
        $sucess = enviarImagens($arquivos['error'][$index], $arquivos['size'][$index], $arquivos['name'][$index], $arquivos['tmp_name'][$index]);
        if(!$sucess) $erros ++;
    }
    if($erros == 0){
        echo "Todos os arquivos foram enviados!";
    }else{
        echo "Um ou mais arquivos não foram enviados!";
    }

}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviando Imagens</title>

    <style>
        /* estilos para o formulário */
        .arquivos {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            max-width: 500px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            width: 100%;
        }

        .arquivos label {
            font-weight: bold;
        }

        .arquivos input[type="file"] {
            margin-top: 10px;
        }

        .arquivos button[type="submit"]{
            background-color: #333;
			color: #fff;
			padding: 10px 20px;
			border-radius: 5px;
			border: none;
			font-size: 16px;
			cursor: pointer;
        }
        .cadastrarUsuario {
            margin-left: 20px;
            background-color: #333;
			color: #fff;
			padding: 10px 20px;
			border-radius: 5px;
			border: none;
			font-size: 16px;
			cursor: pointer;
        }

        .arquivos button[type="submit"]:hover{
            background-color: #555;
        }
        
        .cadastrarUsuario:hover{
            background-color: #555;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            font-size: 16px;
            font-family: Arial, sans-serif;
        }

        thead {
            background-color: #eee;
            text-align: center;
        }

        th {
            padding: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        img {
            max-width: 100px;
            height: auto;
        }

        a {
            color: #337ab7;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        span {
            display: block;
        }

        #titulo {
            font-weight: bold;

        }

        .table {
            align-items: center;
            text-align: center;
        }
    </style>
</head>

<body>
    <form class="arquivos" method="POST" enctype="multipart/form-data">
        <p>
            <label>
                Selecione um arquivo: <br><br>
                <input type="file" name="arquivo[]" multiple><br><br>
            </label>
        </p>
        <button type="submit">Enviar</button>
    </form>
<div>
    <a href="cadastroUsuario.php"><button class="cadastrarUsuario">Cadastrar usuário</button></a>
</div>
    <div class="table">
        <h1 id="titulo">Lista de Arquivos</h1>
        <table>
            <thead>
                <th>Preview</th>
                <th>Arquivo</th>
                <th>Data Upload</th>
            </thead>
            <tbody>
                <?php
                $sqlQuery = $mysqli->query("SELECT * FROM arquivos") or die("Não foi possível buscar os arquivos!");
                while ($arquivo = $sqlQuery->fetch_assoc()) {


                ?>
                    <tr>
                        <td> <img width="100px" height="auto" src="<?php echo $arquivo['path'] ?>" alt=" <?php echo $arquivo['nome'] ?> "> </td>
                        <td> <a href="<?php echo $arquivo['path'] ?>" target="_blank"> <?php echo $arquivo['nome'] ?> </a></td>
                        <td><span><?php $dataHora = new DateTime($arquivo['data_upload']);
                                    echo  $dataHora->format("d/m/y H:i:s"); ?></span></td>
                        <td><a href="indexAdmin.php?deletar=<?php echo $arquivo['id'];?>">Deletar</a> </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

    </div>
</body>

</html>