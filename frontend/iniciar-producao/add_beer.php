<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["categoria"]) && isset($_POST["quantidade"])) {
    require_once("../RestApiClient.php");

    $api = new RestApiClient();
    // convert to int
    $categoria = (int) $_POST["categoria"];
    $quantidade = (int) $_POST["quantidade"];

    $data = array(
      "categoria" => $categoria,
      "quantidade" => $quantidade
    );

    $response = $api->post("OrdemProducao", $data, $_SESSION["token"]);

    if (isset($response["ordemProducao"]["id"])) {
      header("Location: /iniciar-producao?success=true");
    } else {
      header("Location: /iniciar-producao?success=false");
    }
    die();
  }
}
?>