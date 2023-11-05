<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="shortcut icon" href="./img/icon-logo.png"/>
  <title>Dashboard</title>

  <!--CSS-->
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

  <!--PHP-->
  <?php
  //require_once 'Conexao.php';
  //require_once './src/actions/Cliente.php';


  //$clientes = readClienteAction($conn);

  //require_once("./src/database/Categoria.php");
  //require_once("./src/database/Projeto.php");

  //$cliente = new Cliente();
  //$categoria = new Categoria();
  //$projeto = new Projeto();

  //$listacliente = $cliente->listarCliente();
  //$listacategoria = $categoria->listarCategoria();
  //$listaprojeto = $projeto->listarProjeto();

  //include 'Controller/ClienteController.php';


  //$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

  //switch($url)
  //{
  //  case '/dashboard-ein/':
  //    ClienteController::index();
  //    ClienteController::save();
  //    ClienteController::form();
  //  break;
  //}

  //echo $_GET['url'];

  //require_once __DIR__ . '/core/Core.php';
  //require_once __DIR__ . '/Router/routes.php';

  //$core = new Core();
  //$core->run($routes);

  ?>

  <!--JS-->

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
<?php

            include 'Controller/ProjetoController.php';
            
            $projetoCliente = new ProjetoCliente();
            $resultMes = $projetoCliente->Mes();

            list($firstArray, $secondArray) = $projetoCliente->ClientesPorProjeto();
            list($categorias, $projetosPorCategoria) = $projetoCliente->ProjetosPorCategoria();
            list($clientes, $valorProjetos) = $projetoCliente->ClientesLucrativos();

            $totalClientes = $projetoCliente->TotalClientes();
            $totalVendas = $projetoCliente->TotalVendas();
            $mediaNotas = $projetoCliente->NotaProjetos();
            
          ?>
  <div class="navbar w3-sidebar w3-light-grey w3-bar-block">
    
    <div class="bem-vindo">
      <img src="./img/logo1.png" alt="" class="logo">
      <h1>Bem vindo</h1>
    </div>
    <div class="links">
      <a href=""><img src="./img/grafico.png" alt="" width="20px"></a>
      <a href="">Dashboard</a>
    </div>
  </div>
  <div class="all">
    <div class="graficos">

      <div class="principal">
        <div class="total-clientes">
          <div class="cont">
            <h1>Clientes</h1>
            <h2><?php echo($totalClientes) ?></h2>
          </div>
        </div>

        <div class="total-vendas">
          <div class="cont">
            <h1>Vendas</h1>
            <h2><?php echo($totalVendas) ?></h2>
          </div>
        </div>

        <div class="nota-clientes">
          <div class="cont">
            <h1>Qualidade dos projetos</h1>
            <h2><?php echo($mediaNotas) ?> de 10</h2>
          </div>
        </div>
      </div>

      <div class="graficos-01">
        <div class="area">
          <canvas id="myChart" class="grafico01"></canvas>
        </div>
        <div class="area">
          <canvas id="myChart02" class="grafico02"></canvas>
        </div>
      </div>
      <div class="graficos-02">
        <div class="area">
          <canvas id="myChart03" class="grafico03"></canvas>
        </div>
        <div class="area">
          <canvas id="myChart04" class="grafico04"></canvas>
        </div>
      </div>
      <script>
        const ctx = document.getElementById('myChart');
        
        var data = <?php echo json_encode($resultMes, JSON_HEX_TAG); ?>;

        new Chart(ctx, {
          type: 'line',
          data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            datasets: [{
              label: 'Projetos por mês',
              data: data,
              borderWidth: 1,
              backgroundColor: '#ffd966',
              borderColor: '#ffc000',
            }]
          },
          options: {
            indexAxis: 'x',
          }
        });


        const ctx02 = document.getElementById('myChart02');
        var dataClientes = <?php echo json_encode($firstArray, JSON_HEX_TAG); ?>;
        var dataClienteProjeto = <?php echo json_encode($secondArray, JSON_HEX_TAG); ?>;

        new Chart(ctx02, {
          type: 'bar',
          data: {
            labels: dataClientes,
            datasets: [{
              label: 'Projetos por cliente',
              data: dataClienteProjeto,
              borderWidth: 1,
              backgroundColor: '#ffd966',
              borderColor: '#ffd966',
            }]
          },
          options: {

            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });

        const ctx03 = document.getElementById('myChart03');
        var labelCategorias = <?php echo json_encode($categorias, JSON_HEX_TAG); ?>;
        var dataCategorias = <?php echo json_encode($projetosPorCategoria, JSON_HEX_TAG); ?>;

        new Chart(ctx03, {
          type: 'bar',
          data: {
            labels: labelCategorias,
            datasets: [{
              label: 'Projetos por categoria',
              data: dataCategorias,
              borderWidth: 1,
              backgroundColor: '#ffd966',
              borderColor: '#ffd966',
            }]
          },
          options: {

            indexAxis: 'y',
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });

        const ctx04 = document.getElementById('myChart04');
        var labelClientesLucrativos = <?php echo json_encode($clientes, JSON_HEX_TAG); ?>;
        var dataValor = <?php echo json_encode($valorProjetos, JSON_HEX_TAG); ?>;

        new Chart(ctx04, {
          type: 'line',
          data: {
            labels: labelClientesLucrativos,
            datasets: [{
              label: 'Clientes mais lucrativos',
              data: dataValor,
              borderWidth: 1,
              backgroundColor: '#ffd966',
              borderColor: '#ffc000',
            }]
          },
          options: {

            indexAxis: 'x',
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      </script>
    </div>
  </div>
</body>

</html>