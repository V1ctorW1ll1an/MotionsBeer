<?php
session_start();

// global finalizer op error
$_SESSION["finalizerOpError"] = "";

// CHECK REQUEST METHOD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  require_once("../RestApiClient.php");

  $opId = (int) $_POST['opId'];

  $api = new RestApiClient();
  $url = "OrdemProducao/finalizeProductionOrder/{$opId}";
  $response = $api->put($url, [], $_SESSION["token"]);
  if (isset($response["ordemProducaoId"])) {
    header("Location: /pesquisa-producao?finished=true");
  } else {
    if (isset($response["mensagem"]))
      $_SESSION["finalizerOpError"] = $response["mensagem"];
    else
      $_SESSION["finalizerOpError"] = "Erro ao finalizar a OP. Tente novamente.";
    header("Location: /pesquisa-producao?finished=false");
  }

  die();
}
?>