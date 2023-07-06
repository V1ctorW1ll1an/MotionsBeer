<?php
session_start();

// CHECK REQUEST METHOD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  require_once("../RestApiClient.php");

  $processId = (int) $_POST['processId'];
  $nextStep = (int) $_POST['nextStep'];

  $data = array(
    'NovaEtapa' => $nextStep
  );

  $api = new RestApiClient();
  $url = "OrdemProducao/ProcessStep/{$processId}";
  $response = $api->put($url, $data, $_SESSION["token"]);
  if (isset($response["ordemProducao"]["id"])) {
    header("Location: /pesquisa-producao?success=true");
  } else {
    header("Location: /pesquisa-producao?success=false");
  }

  die();
}
?>