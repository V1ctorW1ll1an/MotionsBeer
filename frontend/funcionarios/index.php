<?php
session_start();
if (!isset($_SESSION["usuario"])) {
  header("location:/");
}
require_once '../RestApiClient.php';
$rest = new RestApiClient();

// use the api to get all usuarios
$response = $rest->get("usuario", [
  "pagina" => $_GET["pagina"] ?? 1,
  "tamanhoPagina" => 7,
], $_SESSION['token']);
$usuarios = $response["usuarios"];
//foreach ($usuarios as $usuario) {
//echo $usuario['nome'] . "<br>";
//echo $usuario['email'] . "<br>";
//}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Controle de Produção</title>
  <link rel="shortcut icon" type="image/x-icon" href="./images/favicon.ico">
  <link rel="stylesheet" href="style.css" />
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css">
  <script src="script.js" defer></script>
</head>

<style>
  .table th,
  .table td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: center;
  }

  .table td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: center;
    background-color: #ffffff;
  }

  .card-custom {
    width: 200px;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
  <nav class="navbar flex">
    <i class="bx bx-menu" id="sidebar-open"></i>
    <input type="text" placeholder="Buscar..." class="search_box" />
    <div>
    <button class="button" hidden>Pesquisar</button>
    </div>
  </nav>

  <!-- Site -->
  <div>
    <h1 class="display-2">Controle de Colaboradores</h1>
    <div class="card">
      <div class="col">
        <div class="row">
          <h2 class="mr-2">Cadastros de colaboradores</h2>
        </div>
      </div>
      <div class="col m-3">
        <button class="button" onclick="window.location.href='/cadastro-de-funcionarios/'">Cadastrar
          +</button>
      </div>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Sobernome</th>
          <th>Cpf/Cnpj</th>
          <th>E-mail</th>
          <th>Nivel</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $usuario): ?>
          <tr>
            <td>
              <?php echo $usuario['nome'] ?>
            </td>
            <td>
              <?php echo $usuario['nome'] ?>
            </td>
            <td>
              <?php echo $usuario['cpf'] ?>
            </td>
            <td>
              <?php echo $usuario['email'] ?>
            </td>
            <td>
              <?php
              if ($usuario['nivelDeAcesso'] == 1) {
                echo "Administrador";
              } elseif ($usuario['nivelDeAcesso'] == 2) {
                echo "Técnico";
              } elseif ($usuario['nivelDeAcesso'] == 3) {
                echo "Colaborador";
              }
              ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="pagination">
      <ul>
        <li><a href="/funcionarios?pagina=1" class="active">1</a></li>
        <li><a href="/funcionarios?pagina=2">2</a></li>
        <li><a href="/funcionarios?pagina=3">3</a></li>
        <li><a href="/funcionarios?pagina=4">4</a></li>
        <li><a href="/funcionarios?pagina=5">5</a></li>
      </ul>
    </div>
  </div>
  </div>

  <table class="table">
    <!-- Conteúdo da tabela -->
  </table>
  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.13.0/Sortable.min.js"></script>

  <script>
    function filtrarTabela() {
      var input = document.querySelector('.search_box');
      var filter = input.value.toUpperCase();
      var table = document.querySelector('.table');
      var rows = table.getElementsByTagName('tr');

      for (var i = 0; i < rows.length; i++) {
        var columns = rows[i].getElementsByTagName('td');
        var visible = false;

        for (var j = 0; j < columns.length; j++) {
          var column = columns[j];
          if (column) {
            var text = column.textContent || column.innerText;
            if (text.toUpperCase().indexOf(filter) > -1) {
              visible = true;
              break;
            }
          }
        }

        rows[i].style.display = visible ? '' : 'none';
      }
    }

    var searchButton = document.querySelector('.button');
    searchButton.addEventListener('click', filtrarTabela);

    var searchInput = document.querySelector('.search_box');
    searchInput.addEventListener('keyup', filtrarTabela);
  </script>

  <script>
    // Obtém o número da página a partir da URL
    var urlParams = new URLSearchParams(window.location.search);
    var page = urlParams.get('pagina');

    // Remove a classe "active" de todos os elementos
    var elements = document.querySelectorAll('.pagination a');
    for (var i = 0; i < elements.length; i++) {
      elements[i].classList.remove('active');
    }

    // Adiciona a classe "active" ao elemento da página atual, ou à página 1 se nenhum número de página for especificado
    var currentPageElement;
    if (page) {
      currentPageElement = document.querySelector('.pagination a[href="/funcionarios?pagina=' + page + '"]');
    }
    if (!currentPageElement) {
      currentPageElement = document.querySelector('.pagination a[href="/funcionarios?pagina=1"]');
    }
    currentPageElement.classList.add('active');
  </script>


</body>

</html>