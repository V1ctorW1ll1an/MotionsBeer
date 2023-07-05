<?php
session_start();
require_once 'RestApiClient.php';

// use the api to login
$data = array(
  "email" => "admin@teste.com",
  "senha" => "123456"
);
$rest = new RestApiClient();
$response = $rest->post("login", $data);
var_dump($response);
$token = $response['token'];
echo "Token: " . $token . "<br>";

// use the api to get all usuarios
$response = $rest->get("usuario", [
  "pagina" => 1,
  "tamanhoPagina" => 10
], $_SESSION['token']);
$usuarios = $response["usuarios"];
foreach ($usuarios as $usuario) {
  echo $usuario['nome'] . "<br>";
  echo $usuario['email'] . "<br>";
}

// use the api to get usuario by id
echo "<br>";
echo "usuario com id 7 (troque de acordo com o seu banco, eh apenas um teste): <br>";
$response = $rest->get("usuario/7", [], $token);
$usuario = $response["usuario"];
echo $usuario["nome"] . "<br>";

// login with wrong password
echo "<br>";
echo "Login com senha errada: <br>";
$data = array(
  "email" => "admin@teste.com",
  "senha" => "123456sdasd"
);
$response = $rest->post("usuario", $data);
echo $response . "<br>";

// update user
echo "<br>";
echo "Atualizando um funcionário: <br>";
$data = array(
  "Nome" => "Administrador",
  "Email" => "admin@teste.com",
  "Senha" => "123456789",
  "cpf" => 11111111111,
  "cargo" => 1
);
$response = $rest->put("usuario/7", $data, $token);
echo $response["mensagem"] . "<br>";

// delete user (cuidado ao executar esse codigo)
// echo "<br>";
// echo "Deletando um funcionário: <br>";
// $response = $rest->delete("usuario/7", $token);
// echo $response["mensagem"] . "<br>";

// get all disabled users
echo "<br>";
echo "Funcionários desabilitados: <br>";
$response = $rest->get("usuario/desativados", [], $token);
$usuarios = $response["usuarios"];
foreach ($usuarios as $usuario) {
  echo $usuario['nome'] . "<br>";
  echo $usuario['email'] . "<br>";
}

?>