<?php
session_start();

// global finalizer op error
$_SESSION["updateOPMessage"] = null;
// CHECK REQUEST METHOD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  require_once("../RestApiClient.php");

  $opId = (int) $_POST['opId'];
  $quantidade = (int) $_POST['quantidade'];
  $data = array(
    "quantidade" => $quantidade
  );


  $api = new RestApiClient();
  $url = "OrdemProducao/UpdateQuantity/{$opId}";

  $response = $api->put($url, $data, $_SESSION["token"]);
  if (isset($response["ordemProducao"]["id"]) && isset($response["mensagem"])) {
    $_SESSION["updateOPMessage"] = $response["mensagem"];
    header("Location: /ordem-producao?updated=true");
  } else {
    if (isset($response))
      $_SESSION["updateOPMessage"] = $response;
    else
      $_SESSION["updateOPMessage"] = "Erro ao atualizar a ordem de produção";
    header("Location: /ordem-producao?updated=false");
  }

  die();
}
?>