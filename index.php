<!DOCTYPE html>
<html lang="fr">
<?php require('config.php'); ?>
<?php require('connection.php'); ?>

<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
    if (!isset($_SESSION['login'])) {
      header('Location: /user/login.php');
    }
  }; ?>
<head>
  <title>AKKAPPINESS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, user-scalable=no">

  <link href="assets/fontawesome/css/all.css" rel="stylesheet">
  <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <script src="assets/jquery/jquery-3.4.1.min.js"></script>
  <script src="assets/bootstrap/bootstrap.min.js"></script>
  <script src="assets/js/Chart.min.js"></script>
</head>

<header>
  <nav class="navbar navbar-expand-lg navbar-light bg-light text-uppercase p-1">
    <a class="navbar-brand" href="/"><img src='assets/img/logo.png' alt="logo"> </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link mr-2" href="consultant/show.php">Consultants</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mr-2" href="mission/show.php">Missions</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mr-2" href="customer/show.php">Clients</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mr-2" href="job/show.php">Postes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mr-2" href="enquete/index.php">Enquêtes</a>
        </li>
        <li class="nav-item">
        <a class="nav-link mr-2" href="enquete/show.php">Envoyer</a>
        </li>
        <li class="nav-item logout">
          <a class="nav-link mr-2 " href="user/logout.php"><i class="fas fa-power-off fa-lg"></i></a>
        </li>
      </ul>
    </div>
  </nav>
</header>
<body>
<h2 class="text-center p-4 welcome">BIENVENUE SUR AKKAPPINESS</h2>
<?php
$sql = "SELECT * FROM `enquete` WHERE month(created_at)=month(now()) AND resultat != 0 AND state=0";
$statement = $connection->prepare($sql);
$statement->execute();
$responseTrue = $statement->fetchAll(PDO::FETCH_OBJ);

$sql = "SELECT * FROM `enquete` WHERE month(created_at)=month(now()) AND resultat = 0 AND state = 0";
$statement = $connection->prepare($sql);
$statement->execute();
$responseFalse = $statement->fetchAll(PDO::FETCH_OBJ);

///////////////////////////////////////////////////////////

$sql = "SELECT * FROM `enquete` WHERE resultat = 1 AND month(created_at)=month(now())";
$statement = $connection->prepare($sql);
$statement->execute();
$goodRate = $statement->fetchAll(PDO::FETCH_OBJ);

$sql = "SELECT * FROM `enquete` WHERE resultat = 2 AND month(created_at)=month(now())";
$statement = $connection->prepare($sql);
$statement->execute();
$mediumRate = $statement->fetchAll(PDO::FETCH_OBJ);

$sql = "SELECT * FROM `enquete` WHERE resultat = 3 AND month(created_at)=month(now())";
$statement = $connection->prepare($sql);
$statement->execute();
$badRate = $statement->fetchAll(PDO::FETCH_OBJ);

//////////////////////////////////////////////////////////

?>
  <div class="container">

    <div class="col-md-5 col-lg-6 col-sm-9 row-chart">
      <canvas id="myChart1" width="400" height="400"></canvas>
      <canvas id="myChart2" width="400" height="400"></canvas>
    </div>
  
    <div>
      <canvas id="myChart3"></canvas>
    </div>
  </div>

  <script>
    var ctx = document.getElementById('myChart1').getContext('2d');
    var myChart2 = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ["Répondu", "En attente"],
        datasets: [{
          label: "Nombre de réponses par mois",
          backgroundColor: ["#4F772D", "#D36135"],
          borderWidth: 0,

          data: [<?/*= count($responseTrue); */?>, <?/*= count($responseFalse); */?>, ]
        }]
      },
      options: {
        responsive: true,
        title: {
          fontColor: '#ffff',
          display: true,
          text: 'Total des enquêtes : <?/*= count($responseTrue) + count($responseFalse); */?>'
        },
        legend: {
          display: true,
          labels: {
                fontColor: '#b3cccc'
            }
        },
      }
    });

    var ctx = document.getElementById('myChart2').getContext('2d');
    var myChart2 = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ["Bon", "Moyen", "Mauvais"],
        datasets: [{
          label: "Population (millions)",
          backgroundColor: ["#4F772D", "#D38B5D", "#D36135"],
          borderWidth: 0,

          data: [<?/*= count($goodRate); */?>, <?/*= count($mediumRate); */?>, <?/*= count($badRate); */?>, ]
        }]
      },
      options: {
        responsive: true,
        title: {
          fontColor: '#ffff',
          display: true,
          text: 'Taux de satisfaction  |  Total de réponses : <?/*= count($responseTrue); */?>'
        },
        legend: {
          display: true,
          labels: {
                fontColor: '#b3cccc'
            }
        },
      }
    });


    var myChart3 = new Chart('myChart3', {
  type: 'horizontalBar',
  data: {
        labels: [<?/*="'".implode("','",array_reverse($top5))."'";*/?>],
        datasets: [{
          label: "Meilleur taux de satisfaction",
          backgroundColor: ["#4F772D", "#548687", "#747572", "rgba(255, 180, 67,0.7)", "#D36135"],
          borderWidth: 0,

          data: [<?/*= "'".implode("','",array_reverse($topNote))."'";*/?>]
        }]
      },
  options: {
    responsive: true,
    title: {
          fontColor: '#ffff',
          display: true,
          text: 'Top 5 du taux de satisfaction par client'
        },
  legend: {
          display: false,
        },
    scales: {
      xAxes: [{
        ticks: {
          fontColor: '#b3cccc',
          beginAtZero: true
        },
        scaleLabel: {
          fontColor: '#ffff',
        },
        gridLines: {
          color: '#b3cccc',
        },
      }],
      yAxes: [{
        ticks: {
          fontColor: '#b3cccc',
        },
        gridLines: {
          display: false,
          color: '#b3cccc',
        },
      }],
    }
  }
});
  </script>
</body>

</html>