<?php
session_start();
if (!isset($_SESSION["usuario"])) {
  header("location:/");
}

// op categories
// Tradicional = 1
// Artesanal = 2
// SemAlcool = 3

$opCategories = array(
  1 => "Tradicional",
  2 => "Artesanal",
  3 => "Sem Álcool"
);

function dotnetDateTimeToBrDate($date)
{
  $date = explode("T", $date)[0];
  $date = explode("-", $date);
  return $date[2] . "/" . $date[1] . "/" . $date[0];
}

$currentPage = 1;
$pageLength = 2;

if (isset($_GET["page"])) {
  $currentPage = $_GET["page"];
}

require_once("../RestApiClient.php");

$api = new RestApiClient();

$queries = array(
  "pagina" => $currentPage,
  "tamanhoPagina" => $pageLength
);


$response = $api->get("OrdemProducao/GetAllFinishedProductionOrder", $queries, $_SESSION["token"]);

$ordensProducao = array();
$totalPages = 1;

if (isset($response) && isset($response["ordensProducao"])) {
  $ordensProducao = $response["ordensProducao"];
  $totalPages = $response["totalPages"];
}

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
    width: 35%;
    border-radius: 10px;
    text-align: center;
  }

  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
  }

  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }

  input:not([type="range"]):not([type="color"]) {
    writing-mode: horizontal-tb !important;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    width: 100%;
  }

  .form-input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-bottom: 10px;
  }

  .button-custom {
    padding: 10px 20px;
    background-color: #31c41d;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  body {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
  }

  .table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
  }

  .table th,
  .table td {
    border: 1px solid #ccc;
    padding: 8px;
  }

  .table th {
    background-color: #bcbcbc;
  }

  .card {
    width: 1300px;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .pagination {
    margin-top: 20px;
  }

  .pagination ul {
    list-style-type: none;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .pagination li {
    margin: 0 5px;
  }

  .pagination a,
  .pagination span {
    display: inline-block;
    padding: 5px 10px;
    background-color: #f2f2f2;
    color: #333;
    text-decoration: none;
    border-radius: 5px;
  }

  .pagination a:hover {
    background-color: #ddd;
  }

  .pagination .active {
    background-color: #666;
    color: #fff;
  }

  .button {
    padding: 10px 20px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  .title-container {
    display: flex;
    align-items: center;
  }

  .title-container h2 {
    margin-right: 20px;
  }

  .container-fluid {
    width: 100%
  }

  .button-custom {
    padding: 10px 20px;
    background-color: #f40000;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  .button-custom2 {
    padding: 10px 20px;
    background-color: #31c41d;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
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

  <nav class="navbar flex">
    <i class="bx bx-menu" id="sidebar-open"></i>
    <input type="text" placeholder="Buscar..." class="search_box" />
    <div>
      <button class="button" hidden>Pesquisar</button>
    </div>
  </nav>

  <!-- Cabeçalho -->
  <div>
    <h1 class="display-2">Controle de Estoque</h1>
    <div class="card">
      <div class="container">
        <div class="row">
          <div class="col  m-2">
            <h2>Produto finalizado</h2>
          </div>
        </div>

        <table class="table">
          <thead>
            <tr>
              <th>OP. Nº</th>
              <th>Tipo</th>
              <th>Data Finalização</th>
              <th>Quantidade</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($ordensProducao as $op): ?>
              <tr>
                <td>
                  <?php echo $op["id"] ?>
                </td>
                <td>
                  <?php echo $opCategories[$op["categoria"]] ?>
                </td>
                <td>
                  <?php echo dotnetDateTimeToBrDate($op["dataFim"]) ?>
                </td>
                <td>
                  <?php echo $op["quantidade"] ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <div class="pagination">
          <ul>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <li><a class="<?php if ($i == $currentPage)
                echo "active" ?>" href="?page=<?php echo $i ?>"><?php echo $i ?></a></li>
            <?php endfor; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <table class="table">
    <!-- Conteúdo da tabela -->
  </table>

  <!-- Modal -->
  <div id="myModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <h2>Atualizar </h2>
      <form id="updateForm">
        <div class="form-input">
          <input type="text" id="opNumber" name="opNumber" placeholder="OP. Nº:">
        </div>
        <div class="form-input">
          <input type="number" id="quantity" name="quantity" placeholder="Quantidade:">
        </div>
        <div class="form-input">
          <input type="date" id="deliveryDate" name="deliveryDate" placeholder="Previsão de entrega:">
        </div>
        <div class="form-input">
          <input type="text" id="priority" name="priority" placeholder="Prioridade:">
        </div>
        <div class="form-input">
          <input type="text" id="type" name="type" placeholder="Tipo:">
        </div>
        <div class="form-input">
          <input type="date" id="startDate" name="startDate" placeholder="Data de início:">
        </div>

        <button class="button-custom" type="submit">Atualizar</button>
      </form>
    </div>
  </div>

  <script>
    // Função para abrir o modal
    function openModal() {
      document.getElementById("myModal").style.display = "block";
    }

    // Função para fechar o modal
    function closeModal() {
      document.getElementById("myModal").style.display = "none";
    }

    // Event listener para o envio do formulário
    document.getElementById("updateForm").addEventListener("submit", function (event) {
      event.preventDefault();
      // Aqui você pode adicionar a lógica para atualizar os dados no backend
      closeModal();
    });
  </script>
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

</body>

</html>