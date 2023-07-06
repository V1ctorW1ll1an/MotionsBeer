<?php
session_start();
if (!isset($_SESSION["usuario"])) {
  header("location:/");
}

$isSuccess = null;

if (isset($_GET["success"])) {
  $isSuccess = $_GET["success"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menu Principal</title>
  <link rel="shortcut icon" type="image/x-icon" href="./images/favicon.ico">
  <link rel="stylesheet" href="style.css" />
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css">
  <script src="script.js" defer></script>
</head>

<style>
  .alert {
    padding: 20px;
    margin: 10px 0;
  }

  .alert.alert-success {
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
  }

  .alert.alert-error {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
  }

  /* Estilos para o botão do modal */
  #quantidade-form button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
  }

  #quantidade-form button:hover {
    background-color: #45a049;
  }

  /* Estilos para o input do modal */
  #quantidade-engradados {
    width: 70%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    box-sizing: border-box;
    margin-bottom: 10px;
  }

  /* Estilos para o modal */
  .modal {
    /* ... */
    animation: fadeIn 0.5s ease-out;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* ... */
  /* Estilos para o modal */
  .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
  }

  .modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 40%;
    max-width: 500px;
    border-radius: 5px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    position: relative;
  }

  .close {
    position: absolute;
    top: 0;
    right: 15px;
    font-size: 24px;
    font-weight: bold;
    color: #888;
    cursor: pointer;
  }

  .card2 {
    transition: transform 0.3s ease;
  }

  .card2:hover {
    transform: scale(1.1);
  }

  .card2 {
    cursor: pointer;
  }

  .card-custom {
    width: 200px;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .card-custom {
    display: inline-block;
    width: 32.7%;
    height: 518px;
    padding: 5px 10px;
    background-color: #f2f2f2;
    color: #333;
    text-decoration: none;
    border-radius: 5px;
  }

  .card2 {
    display: inline-block;
    width: 33%;
    background-color: rgba(251, 251, 253, .92);
    ;
    border-radius: 5px;
    padding: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .card2 img {
    width: 100%;
    border-radius: 5px;
  }

  .card2-content {
    margin-top: 10px;
  }

  .card2-content h2 {
    font-size: 18px;
    margin-bottom: 5px;
  }

  .card2-content p {
    font-size: 14px;
  }
</style>

<body>

  <!-- BARRA DE MENU -->
  <nav class="sidebar hoverable close">
    <div class="logo_items flex">
      <span class="nav_image">
        <img src="images/logo.png" alt="logo_img" />
      </span>
      <span class="logo_name">Motions'Beer</span>
      <i class="bx bx-lock-open-alt" id="lock-icon" title="Unlock Sidebar"></i>
      <i class="bx bx-x" id="sidebar-close"></i>
    </div>

    <div class="menu_container">
      <div class="menu_items">
        <li class="item">
          <a href="/iniciar-producao/" class="link flex">
            <i class='bx bx-play-circle'></i>
            <span>Criar Cerveja</span>
          </a>
        </li>

        <li class="item">
          <a href="/pesquisa-producao/" class="link flex">
            <i class='bx bx-select-multiple'></i>
            <span>Acompanhar Processo</span>
          </a>
        </li>

        <li class="item">
          <a href="/ordem-producao/" class="link flex">
            <i class='bx bx-barcode'></i>
            <span>Ordem Produção</span>
          </a>
        </li>

        <li class="item">
          <a href="/controle-de-producao/" class="link flex">
            <i class='bx bxs-package'></i>
            <span>Controle de Estoque</span>
          </a>
        </li>

        <li class="item">
          <a href="/dashboard/" class="link flex">
            <i class='bx bxs-pie-chart-alt-2'></i>
            <span>Indicadores</span>
          </a>
        </li>

        <li class="item">
          <a href="/vendas/" class="link flex">
            <i class='bx bx-shopping-bag'></i>
            <span>Vendas</span>
          </a>
        </li>

        <li class="item">
          <a href="/clientes/" class="link flex">
            <i class='bx bx-user'></i>
            <span>Clientes</span>
          </a>
        </li>

        <li class="item">
          <a href="/funcionarios/" class="link flex">
            <i class='bx bxs-id-card'></i>
            <span>Colaboradores</span>
          </a>
        </li>

        <li class="item">
          <a href="/logout.php" class="link flex">
            <i class='bx bx-log-out'></i>
            <span>Logout</span>
          </a>
        </li>

      </div>
      <!-- RODAPE USUARIO -->
      <div class="sidebar_profile flex">
        <span class="nav_image">
          <img src="images/profile.png" alt="logo_img" />
        </span>
        <div class="data_text">
          <span class="email">
            <?php echo $_SESSION["usuario"]["email"] ?>
          </span>
        </div>
      </div>
    </div>
  </nav>
  </div>
  </nav>
  </div>
  </nav>

  <nav class="navbar flex">
    <i class="bx bx-menu" id="sidebar-open"></i>
  </nav>

  <!-- Site -->
  <div>
    <h1 class="display-2">Vamos iniciar a criação
      <?php echo $_SESSION["usuario"]["nome"] ?>
    </h1>
    <div>
      <?php
      if ($isSuccess != null) {
        if ($isSuccess == "true") {
          echo "<div class='alert alert-success' role='alert'>
                    Ordem de Produção adicionada com sucesso! Acompanhe o processo na guia 'Acompanhar Processo'.
                  </div>";
        } else {
          echo "<div class='alert alert-error' role='alert'>
                    Erro ao adicionar Ordem de Produção!
                </div>";
        }
      }
      ?>
    </div>
    <div class="card">
      <div class="col">
        <div class="row">
          <div class="col  m-2">
            <div class="card2" onclick="abrirModal()">
              <h1>Tadicional</h1>
              <h3>A Tradicional Brasileira</h3>
              <img src="/menu/images/card2.jpg" alt="Descrição da imagem">
            </div>
            <!-- modal -->
            <div id="modal" class="modal">
              <div class="modal-content">
                <span class="close" onclick="fecharModal()">&times;</span>
                <form id="quantidade-card1" action="/iniciar-producao/add_beer.php" method="POST">
                  <input type="text" id="categoria" name="categoria" hidden value="1" />
                  <input type="number" id="quantidade" placeholder="Quantidade de Engradados:" name="quantidade"
                    required min="1" />
                  <button type="submit">Confirmar</button>
                </form>
              </div>
            </div>

            <div class="card2" onclick="abrirModal1()">
              <h1>Artesanal</h1>
              <h3>Receita Ar</h3>
              <img src="/menu/images/card1.jpg" alt="Descrição da imagem">
            </div>
            <!-- modal -->
            <div id="modal1" class="modal">
              <div class="modal-content">
                <span class="close" onclick="fecharModal1()">&times;</span>
                <form id="quantidade-card2" action="/iniciar-producao/add_beer.php" method="POST">
                  <input type="text" id="categoria" name="categoria" hidden value="2" />
                  <input type="number" id="quantidade" placeholder="Quantidade de Engradados:" name="quantidade"
                    required min="1" />
                  <button type="submit">Confirmar</button>
                </form>
              </div>
            </div>

            <div class="card2" onclick="abrirModal2()">
              <h1>Não alcoolica</h1>
              <h3>Fermentando o milho</h3>
              <img src="/menu/images/card3.jpg" alt="Descrição da imagem">
            </div>
          </div>
          <!-- modal -->
          <div id="modal2" class="modal">
            <div class="modal-content">
              <span class="close" onclick="fecharModal2()">&times;</span>
              <form id="quantidade-card3" action="/iniciar-producao/add_beer.php" method="POST">
                <input type="text" id="categoria" name="categoria" hidden value="3" />
                <input type="number" id="quantidade" placeholder="Quantidade de Engradados:" name="quantidade" required
                  min="1" />
                <button type="submit">Confirmar</button>
              </form>
            </div>
          </div>

          <h2 class="mr-2">Selecione qual categoria de cerveja deseja criar</h2>
        </div>
      </div>
    </div>

    <script>
      function redirecionarParaPagina(url) {
        window.location.href = url;
      }
    </script>

    <script>
      function abrirModal() {
        document.getElementById('modal').style.display = 'block';
      }

      function fecharModal() {
        document.getElementById('modal').style.display = 'none';
      }
    </script>

    <script>
      function abrirModal1() {
        document.getElementById('modal1').style.display = 'block';
      }

      function fecharModal1() {
        document.getElementById('modal1').style.display = 'none';
      }
    </script>

    <script>
      function abrirModal2() {
        document.getElementById('modal2').style.display = 'block';
      }

      function fecharModal2() {
        document.getElementById('modal2').style.display = 'none';
      }
    </script>


</body>

</html>