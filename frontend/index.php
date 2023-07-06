<?php
session_start();
if (isset($_SESSION["usuario"])) {
	header("location:/menu");
}

$added = null;

if (isset($_GET["added"])) {
	$added = $_GET["added"];
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<title>Sistema Motions'Beer</title>
	<link rel="shortcut icon" type="image/x-icon" href="./imagens/favicon.ico">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">

</head>

<style>
	body {
		background: url(./imagens/Cervejaria.jpg)no-repeat;
	}

	.custom-message-container {
		text-align: center;
		padding: 10px;
		color: red;
		background-color: rgb(254, 136, 136);
		border-radius: 8px;
	}

	@media (max-width: 980px) {

		h1 {
			margin: 0;
			padding: 0 0 70px;
			text-align: center;
			font-size: 2vh;
			line-height: 160px;
		}

		.loginbox {
			width: 66%;
			height: auto !important;
			background: #fff;
			color: #344a6d;
			top: 50%;
			left: 50%;
			position: absolute;
			transform: translate(-50%, -50%);
			box-sizing: border-box;
			padding: 70px 30px;
			border-radius: 60px;
		}

		.avatar {
			width: 300px;
			height: 300px;
			border-radius: 50%;
			position: absolute;
			top: -24%;
			left: calc(50% - 150px);
			border: none;
		}

		.loginbox input[type="submit"] {
			border: none;
			outline: none;
			margin-left: 150px;
			width: 300px;
			height: 80px;
			background: #3f3b3c;
			color: #ffffff;
			font-size: 50px;
			border-radius: 20px;
			-webkit-transition: all 0.3s;
			-o-transition: all 0.3s;
		}

		.loginbox input[type="text"],
		input[type="password"] {
			border: none;
			border-bottom: 1px solid #000;
			background: transparent;
			outline: none;
			height: 200px;
			color: #000;
			font-size: 50px;
			text-align: center;
		}

		.loginbox input[type="text"],
		input[type="password"] {
			border: none;
			border-bottom: 1px solid #000;
			background: transparent;
			outline: none;
			height: 80px;
			color: #000;
			font-size: 58px;
			text-align: center;
		}

		.loginbox a {
			text-decoration: none;
			font-size: 36px;
			line-height: 150px;
			color: #000;
		}



		body {
			background: url(./imagens/Cervejaria.jpg) no-repeat;
			background-position: center center;
			/* Centraliza o wallpaper horizontal e verticalmente */
			background-size: cover;
			/* Ajusta o tamanho do wallpaper para cobrir todo o fundo */
		}


	}

	.alert {
		padding: 20px;
		margin: 10px 0;
	}

	.alert.alert-success {
		color: #3c763d;
		background-color: #dff0d8;
		border-color: #d6e9c6;
	}

	.alert.alert-error {
		color: #a94442;
		background-color: #f2dede;
		border-color: #ebccd1;
	}
</style>

<body>
	<div class="loginbox">
		<img src="imagens/beer.png" class="avatar">
		<h1>Bem vindo a
			Motions'Beer
		</h1>
		<div>
			<?php
			if ($added != null) {
				if ($added == "true") {
					echo "<div class='alert alert-success' role='alert'>
                  {$_SESSION["addUserMessage"]}
                </div>";
				} else if (isset($_SESSION["addUserMessage"])) {
					echo "<div class='alert alert-error' role='alert'>
                   {$_SESSION["addUserMessage"]}
                </div>";
				} else {
					echo "<div class='alert alert-error' role='alert'>
                   Erro ao se cadastrar, por favor tente novamente.
                </div>";
				}
			}
			?>
		</div>

		<form method="post" action="autenticacao.php">
			<?php if (isset($_SESSION["login_status"]) && $_SESSION["login_status"] === "error"): ?>
				<?php if (isset($_SESSION["mensagem"])): ?>
					<div class="custom-message-container">
						<script>
							alert("<?php echo $_SESSION['mensagem']; ?>");
						</script>
					</div>
				<?php endif ?>
			<?php endif ?>
			<input type="text" name="login" id="login" placeholder="Digite seu login" required>
			<input type="password" name="senha" id="senha" placeholder="Digite sua senha" required>
			<input type="submit" name="" value="Entrar">
			<center>
				<p><u><a href="/cadastro.php">Cadastrar</a></u></p>
			</center>
		</form>
	</div>
	<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.13.0/Sortable.min.js"></script>
</body>

</html>