<?php

include("conexaoBd.php");
session_start();
    if(isset($_SESSION['id_usuario']) && isset($_SESSION['nome_usuario']) && isset($_SESSION['permissao_usuario'])){
        echo "Usuário Logado!";
}else{
    header("Location: login.php");
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

        .arquivos button[type="submit"] {
            background-color: #333;
			color: #fff;
			padding: 10px 20px;
			border-radius: 5px;
			border: none;
			font-size: 16px;
			cursor: pointer;
        }

        .arquivos button[type="submit"]:hover {
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
                        
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

    </div>
</body>

</html>