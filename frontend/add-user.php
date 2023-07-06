<?php
session_start();

// global finalizer op error
$_SESSION["addUserMessage"] = null;
// CHECK REQUEST METHOD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  require_once("RestApiClient.php");

  // post nome, cpf, email e senha
  $nomeCompleto = $_POST['nomeCompleto'];
  $cpf = (int) $_POST['cpf'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  $data = array(
    "nome" => $nomeCompleto,
    "email" => $email,
    "senha" => $password,
    "cpf" => $cpf,
    "nivelDeAcesso" => 2
  );


  $api = new RestApiClient();
  $url = "usuario";

  $response = $api->post($url, $data);

  if (isset($response["usuario"]["id"]) && isset($response["mensagem"])) {
    $_SESSION["addUserMessage"] = $response["mensagem"];
    header("Location: /?added=true");
  } else {
    if (isset($response))
      $_SESSION["addUserMessage"] = $response;
    else
      $_SESSION["addUserMessage"] = "Estamos com problemas para cadastrar o usuário, tente novamente mais tarde.";
    header("Location: /?added=false");
  }

  die();
}
?>