<?php
session_start();
if (!isset($_SESSION["usuario"])) {
  header("location:/");
}
require_once '../RestApiClient.php';
$rest = new RestApiClient();
$response = $rest->post("login", $data);
var_dump($response);
$token = $response['token'];

$sql = "INSERT INTO dbo_bordado (tipo_bordado, quantidade_pontos, tempo_bordado, cliente_bordado) VALUES ('$tipoBordado', $quantidadePontos, '$tempoBordado', '$clienteBordado')";























?>