<?php
session_start();
if (!isset($_SESSION["usuario"])) {
  header("location:/");
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

  <title>Exemplo de Redirecionamento</title>
  <script>
    // Função para lidar com o clique no botão
    function redirecionar() {
      // Exibe um prompt para o usuário escolher entre Sim ou Não
      var resposta = prompt("Deseja parar? Digite 'sim' ou 'nao'");

      // Verifica a resposta do usuário
      if (resposta === "sim") {
        // Redireciona para a página de destino para "Sim"
        window.location.href = "pagina_sim.html";
      } else if (resposta === "nao") {
        // Redireciona para a página de destino para "Não"
        window.location.href = "pagina_nao.html";
      } else {
        // Caso a resposta não seja "sim" ou "nao", exibe um alerta
        alert("Resposta inválida!");
      }
    }
  </script>
</head>

<style>
  
  .button-custom i.bx-stop {
    font-size: 26px; /* Tamanho do ícone aumentado */
    /* Outros estilos opcionais para o ícone */
  }

  .button-custom2 i.bx-skip-next {
    font-size: 26px; /* Tamanho do ícone aumentado */
    /* Outros estilos opcionais para o ícone */
  }
  
  .button-custom3 i.bx-reset {
    color: #ffffff;
    font-size: 26px; /* Tamanho do ícone aumentado */
    /* Outros estilos opcionais para o ícone */
  }

  progress {
    appearance: auto;
    width: 20%;
    border-radius: 10px;
    inline-size: 5em;
    border-radius: 5px;

  }

  /* Estilo para centralizar o conteúdo */
  body {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
  }

  /* Estilo para a tabela */
  .table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
  }

  .table th,
  .table td {
    border: 1px solid #ccc;
    padding: 8px;
    vertical-align: bottom;
  }

  .table th {
    background-color: #bcbcbc;
  }

  /* Estilo para o card */
  .card {
    width: 1296px;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  /* Estilo para a paginação */
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

  /* Estilo para o botão */
  .button {
    padding: 10px 20px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  /* Estilo para o contêiner do título e do botão */
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
    background-color: #089400;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  .button-custom3 {
    padding: 10px 20px;
    background-color: #235ff5;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  .botoes-alinhados {
    display: inline-block;
    padding: 5px 10px;
    background-color: #f2f2f2;
    color: #333;
    text-decoration: none;
    border-radius: 5px;
  }

  .botoes-alinhados-transf {
    display: inline-block;
    padding: 5px 10px;
    background-color: #019108;
    color: #ffffff;
    text-decoration: none;
    border-radius: 5px;
  }

  .botoes-alinhados-para {
    display: inline-block;
    padding: 5px 10px;
    background-color: #d90808;
    color: #ffffff;
    text-decoration: none;
    border-radius: 5px;
  }

  .table th,
  .table td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: center;
  }

  .info-icon {
    font-weight: bold;
    font-size: 20px;
    color: #486dff;
    margin-left: 5px;
    cursor: help;
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
    <h1 class="display-2">Acompanhar Processo</h1>
    <div class="card">
      <div class="container">
        <div class="row">
          <div class="col  m-2">
            <h2>Controle de tempo e instrução</h2>
          </div>
        </div>

        <table class="table">
          <thead>
            <tr>
              <th>
                Ordem Produção
              </th>
              <th>
              <a href="pagina_de_informacoes.html" class="info-icon"><span class="circle"></span>ⓘ</a>
              Maltagem...
              </th>
              <th>
                <a href="pagina_de_informacoes.html" class="info-icon"><span class="circle"></span>ⓘ</a>
                Moedura...
              </th>
              <th>
                <a href="pagina_de_informacoes.html" class="info-icon"><span class="circle"></span>ⓘ</a>
                Brassagem...
              </th>
              <th>
                <a href="pagina_de_informacoes.html" class="info-icon"><span class="circle"></span>ⓘ</a>
                Filtragem... 
              </th>
              <th>
                <a href="pagina_de_informacoes.html" class="info-icon"><span class="circle"></span>ⓘ</a>
                Fervura...
              </th>
              <th>
                <a href="pagina_de_informacoes.html" class="info-icon"><span class="circle"></span>ⓘ</a>
                Clarificação...
              </th>
              <th>
                <a href="pagina_de_informacoes.html" class="info-icon"><span class="circle"></span>ⓘ</a>
                Engarrafamento...
              </th>
              
              <th></th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                00001
              </td>
              <td>
                Finalizado
                <progress value="100" max="100"></progress>
              </td>
              <td>
                Finalizado
                <progress value="100" max="100"></progress>
              </td>
              <td>
                Faltam: 26hrs
                <progress value="52" max="100"></progress>
              </td>
              <td>
                Aguardando
                <progress value="0" max="100"></progress>
              </td>
              <td>
                Aguardando
                <progress value="0" max="100"></progress>
              </td>
              <td>
                Aguardando
                <progress value="0" max="100"></progress>
              </td>
              <td>
                Aguardando
                <progress value="0" max="100"></progress>
              </td>
              

              <td><button class="button-custom" onclick="redirecionar()"><i class='bx bx-stop'></i></button></td>
              <td><button class="button-custom3" onclick="redirecionar()"><i class='bx bx-reset'></i></button></td>
              <td><button class="button-custom2"
                  onclick="window.location.href='/transferencia-de-producao/'"><i class='bx bx-skip-next'></i></button></td>
            </tr>
          </tbody>
        </table>
        <div class="pagination">
          <ul>
            <li><a href="#" class="active">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
          </ul>
        </div>
      </div>
    </div>
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