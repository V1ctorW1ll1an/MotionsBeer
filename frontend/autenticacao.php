<?php
// importar o restClient
require_once('./RestApiClient.php');

// verifica se o methodo é post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // pegar o email e a senha do post
  $email = $_POST['login'];
  $senha = $_POST['senha'];

  $dados = array(
    "email" => $email,
    "senha" => $senha
  );
  // instancia o objeto
  $restClient = new RestApiClient();
  // verificar se o email e a senha estão corretos
  $response = $restClient->post('login', $dados);

  // se o token for diferente de null
  if (isset($response["token"]) && $response['token'] != null) {
    
    // inicia a sessão
    session_start();
    // cria uma variavel de sessão com o token
    $_SESSION['token'] = $response['token'];
    $_SESSION['usuario'] = $response['usuario'];
    // redireciona para a pagina de funcionarios
    header('Location: /menu/');
  } else if (isset($response) != null) {
    // se a mensagem for diferente de null
    // mostra a mensagem de erro
    session_start();
    $_SESSION["login_status"] = "error";
    $_SESSION["mensagem"] = $response;
    header('Location: /');
  }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/x-icon" href="./imagens/favicon.ico">
  <link rel="stylesheet" type="text/css" href="css/estilo.css">
  <link rel="stylesheet" type="text/css" href="css/autenticacao.css">
</head>

<body>

</body>

</html>