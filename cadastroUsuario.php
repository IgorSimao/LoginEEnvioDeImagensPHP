<?php
include("conexaoBd.php");
if(isset($_POST['nome']) and isset($_POST['email']) and isset($_POST['senha'])){
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $permissao = $_POST['permissao'];
    $senhaHash = password_hash($_POST['senha'], PASSWORD_DEFAULT);


$sql = "INSERT INTO usuarios (nome, email, senha, permissao) VALUES ('$nome', '$email', '$senhaHash', '$permissao')";
if ($mysqli->query($sql) === TRUE) {
    echo "Usuário cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar usuário: " . $mysqli->error;
}

$mysqli->close();
}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Cadastro de Usuários</title>
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

		input[type="text"],
		input[type="email"],
		input[type="password"],
		select {
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

<h1>Cadastro de Usuários</h1>

<form method="post">
	<label for="nome">Nome:</label>
	<input type="text" id="nome" name="nome" required><br>

	<label for="email">E-mail:</label>
	<input type="email" id="email" name="email" required><br>

	<label for="senha">Senha:</label>
	<input type="password" id="senha" name="senha" required><br>

	<label for="permissao">Permissões:</label>
	<select id="permissao" name="permissao">
		<option value="0">Usuário comum</option>
		<option value="1">Administrador</option>
	</select><br>

	<input type="submit" value="Cadastrar">
</form>

</body>
</html>