<?php
session_start();

// global finalizer op error
$_SESSION["deleteOPMessage"] = null;
// CHECK REQUEST METHOD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  require_once("../RestApiClient.php");

  $opId = (int) $_POST['opId'];



  $api = new RestApiClient();
  $url = "OrdemProducao/DeleteProductionOrder/{$opId}";

  $response = $api->delete($url, $_SESSION["token"]);
  if (isset($response["ordemProducaoId"]) && isset($response["mensagem"])) {
    $_SESSION["deleteOPMessage"] = $response["mensagem"];
    header("Location: /ordem-producao?deleted=true");
  } else {
    if (isset($response))
      $_SESSION["deleteOPMessage"] = $response;
    else
      $_SESSION["deleteOPMessage"] = "Erro ao apagar a ordem de produção";
    header("Location: /ordem-producao?deleted=false");
  }

  die();
}