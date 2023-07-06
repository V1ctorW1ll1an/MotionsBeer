<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" type="image/x-icon" href="./imagens/favicon.ico">
  <link rel="stylesheet" type="text/css" href="../css/estilo2.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>


  <title>Solicitar Cadastro</title>

  <style>
    body {
      background: url(./imagens/cervejaria.jpg) no-repeat;
    }

    .content {
      background-color: white;
      margin: 5% auto;
      max-width: 520px;
      padding: 50px;
      border-radius: 20px;
      box-sizing: border-box;
    }

    .loginbox {
      text-align: center;
    }

    .form-header {
      font-size: 24px;
      margin-bottom: 20px;
    }

    .custom-input {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    .custom-button {
      padding: 10px 20px;
      background-color: #b39801;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .custom-button2 {
      padding: 10px 20px;
      background-color: #656565;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .custom-button3 {
      padding: 10px 20px;
      background-color: #f66301;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .custom-button:hover {
      background-color: #b3c337e7;
    }
  </style>
</head>

<body>

  <form class="form" method="post" action="add-user.php">
    <div class="loginbox">
      <img src="imagens/user.png" class="avatar" width="60px" height="60px">
      <h1 class="form-header">Reaalize o seu cadastro e venha ser nosso companheiro de copo!</h1>
      <div class="mb-3">
        <input type="text" class="form-control custom-input" id="nomeCompleto" name="nomeCompleto"
          placeholder="Digite seu nome">
      </div>

      <div class="mb-3">
        <input type="number" class="form-control custom-input" id="cpf" name="cpf"
          placeholder="Digite o cpf...  00000000000">
      </div>

      <div class="mb-3">
        <input type="email" name="email" class="form-control custom-input" id="email" placeholder="name@example.com">
      </div>

      <div class="mb-3">
        <input type="password" name="password" class="form-control custom-input" id="password"
          placeholder="Digite sua senha">
      </div>


      <button type="submit" class="custom-button">Cadastrar</button>
      <button type="button" onclick="window.location.href='/'" class="custom-button3">Voltar</button>
    </div>
  </form>

  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.13.0/Sortable.min.js"></script>
</body>

</html>