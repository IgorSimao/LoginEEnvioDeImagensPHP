<?php
include("conexaoBd.php");

if(isset($_POST['email']) && isset($_POST['senha'])){

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $query = "SELECT * FROM usuarios WHERE email='$email' LIMIT 1";

    $query_exec = $mysqli -> query($query) or die($mysqli->error);//die mata a execução

    $qtd_rows = $query_exec->num_rows;
    if($qtd_rows == 1){
        $usuario = $query_exec->fetch_assoc();
        // var_dump($usuario);
        // echo "result".password_verify('123', '$2y$10$mVqUJU0b0r1CjMZjV0pVIOJm4uCUprMKGQ24ZPlEItCsFkdewWNri');
        if(password_verify($senha, $usuario['senha'])){
            session_start();
            echo "Usuário Conectado!";
            $_SESSION["id_usuario"] = $usuario["id"];
		    $_SESSION["nome_usuario"] = $usuario["nome"];
		    $_SESSION["permissao_usuario"] = $usuario["permissao"];

            if($usuario["permissao"] == 1){
                header("Location: indexAdmin.php");
            }else{
                header("Location: index.php");
            }
		    
        }else{
            echo "Senha Incorreta!";
        }
    }else{
        echo "Usuário não cadastrado!";
    }
		

	mysqli_close($mysqli);
}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f2f2f2;
		}

		h1 {
			text-align: center;
			color: #333;
		}

		form {
			width: 400px;
			margin: 0 auto;
			background-color: #fff;
			padding: 20px;
			border-radius: 5px;
			box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
		}

		label {
			display: block;
			margin-bottom: 10px;
			color: #666;
		}

		input[type="email"],
		input[type="password"] {
			width: 100%;
			padding: 10px;
			border-radius: 5px;
			border: none;
			background-color: #f9f9f9;
			margin-bottom: 20px;
			box-sizing: border-box;
			font-size: 16px;
			color: #666;
		}

		input[type="submit"] {
			background-color: #333;
			color: #fff;
			padding: 10px 20px;
			border-radius: 5px;
			border: none;
			font-size: 16px;
			cursor: pointer;
		}

		input[type="submit"]:hover {
			background-color: #555;
		}
	</style>
</head>
<body>

<h1>Login</h1>

<form method="post">
	<label for="email">E-mail:</label>
	<input type="email" id="email" name="email" required>

	<label for="senha">Senha:</label>
	<input type="password" id="senha" name="senha" required>

	<input type="submit" value="Entrar">
</form>

</body>
</html>
