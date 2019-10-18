<!DOCTYPE html>
<html lang="fr">
<?php require('config.php'); ?>
<?php require('connection.php'); ?>

<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
    if (!isset($_SESSION['login'])) {
      header('Location: /Akkappiness/user/login.php');
    }
  }; ?>
<head>
  <title>AKKAPPINESS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, user-scalable=no">

  <link href="assets/fontawesome/css/all.css" rel="stylesheet">
  <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <script src="assets/js/Chart.min.js"></script>

</head>

<header>
  <nav class="navbar navbar-expand-lg navbar-light bg-light text-uppercase p-1">
    <a class="navbar-brand" href="/Akkappiness"><img src='assets/img/logo.png' alt="logo"> </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link mr-2" href="/Akkappiness/consultant/show.php">Consultants</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mr-2" href="/Akkappiness/mission/show.php">Missions</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mr-2" href="/Akkappiness/customer/show.php">Clients</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mr-2" href="/Akkappiness/job/show.php">Métiers</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mr-2" href="/Akkappiness/enquete/index.php">Enquêtes</a>
        </li>
        <li class="nav-item">
        <a class="nav-link mr-2" href="/Akkappiness/enquete/show.php">A envoyer</a>
        </li>
        <li class="nav-item logout">
          <a class="nav-link mr-2 " href="/Akkappiness/user/logout.php"><i class="fas fa-power-off fa-lg"></i></a>
        </li>
      </ul>
    </div>
  </nav>
</header>
<?php
$sql = "SELECT * FROM `enquete` WHERE resultat != 0";
$statement = $connection->prepare($sql);
$statement->execute();
$responseTrue = $statement->fetchAll(PDO::FETCH_OBJ);

$sql = "SELECT * FROM `enquete` WHERE resultat = 0";
$statement = $connection->prepare($sql);
$statement->execute();
$responseFalse = $statement->fetchAll(PDO::FETCH_OBJ);

//////////////////////////////////////////////////////////

$sql = "SELECT * FROM `enquete` WHERE resultat = 1";
$statement = $connection->prepare($sql);
$statement->execute();
$goodRate = $statement->fetchAll(PDO::FETCH_OBJ);

$sql = "SELECT * FROM `enquete` WHERE resultat = 2";
$statement = $connection->prepare($sql);
$statement->execute();
$mediumRate = $statement->fetchAll(PDO::FETCH_OBJ);

$sql = "SELECT * FROM `enquete` WHERE resultat = 3";
$statement = $connection->prepare($sql);
$statement->execute();
$badRate = $statement->fetchAll(PDO::FETCH_OBJ);

//////////////////////////////////////////////////////////

$sql = "SELECT count(c.name) customer, c.name, e.state 
        FROM enquete e
        JOIN mission m
        ON m.id = e.mission_id
        JOIN customer c
        ON c.id = m.customer_id
        WHERE e.state = 0 
        GROUP BY c.name
        ORDER BY customer DESC
        LIMIT 5";
$statement = $connection->prepare($sql);
$statement->execute();
$enqueteByCustomer = $statement->fetchAll(PDO::FETCH_OBJ);


$sql = "SELECT COUNT(e.resultat) as nbrDeBien, c.name 
        FROM enquete e
        JOIN mission m ON m.id = e.mission_id
        JOIN customer c ON m.customer_id = c.id
        WHERE resultat = 1
        GROUP BY c.name
        ORDER BY nbrDeBien DESC
        LIMIT 5";
$statement = $connection->prepare($sql);
$statement->execute();
$goodRateByCustomer = $statement->fetchAll(PDO::FETCH_OBJ);


$arrayCustomer = [];
$arrayNbrDeBien = [];
$arrayNbrEnquete = [];
foreach($goodRateByCustomer as $row){
  
  $arrayNbrDeBien[] = $row->nbrDeBien;
  $arrayCustomer[] = $row->name;
}

 foreach($enqueteByCustomer as $enquete){
  $arrayNbrEnquete[] = $enquete->customer;
} 

$Note1 = round(($arrayNbrDeBien[0] / $arrayNbrEnquete[0])*100);
$Note2 = round(($arrayNbrDeBien[1] / $arrayNbrEnquete[1])*100);
$Note3 = round(($arrayNbrDeBien[2] / $arrayNbrEnquete[2])*100);
$Note4 = round(($arrayNbrDeBien[3] / $arrayNbrEnquete[3])*100);
$Note5 = round(($arrayNbrDeBien[4] / $arrayNbrEnquete[4])*100);

$customerNote = [ $arrayCustomer[0] => $Note1 ,
                   $arrayCustomer[1] => $Note2 ,
                   $arrayCustomer[2] => $Note3 ,
                   $arrayCustomer[3] => $Note4 ,
                   $arrayCustomer[4] => $Note5 ,
                  ];

ksort($customerNote);

foreach ($customerNote as $key => $val) {
  $key = $val;
}

$top5Customers = [];
$top5Rate = [];

foreach($customerNote as $customer => $key){
  $top5Customers[] = $key;
  $top5Rate[] = $customer;
}
arsort($customerNote);

$topNote = [];
foreach ($customerNote as $note => $value) {
  $topNote[] = $value;
}
$top5 = [];
foreach($customerNote as $enterprise => $value){
  $top5[] = $enterprise;
}




$sql = "SELECT * FROM `enquete` WHERE resultat = 3";
$statement = $connection->prepare($sql);
$statement->execute();
$badRate = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<body>
  <h2 class="text-center p-4 welcome">BIENVENUE SUR AKKAPPINESS</h2>
  <div class="container">
    <div class="col-md-5 col-lg-6 col-sm-12 d-flex justify-center">
      <canvas id="myChart1" width="400" height="400"></canvas>
      <canvas id="myChart2" width="400" height="400"></canvas>
    </div>
    <div>
      <canvas id="myChart3"></canvas>
    </div>
  </div>

  <script>
    var ctx = document.getElementById('myChart1').getContext('2d');
    var myChart1 = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ["Taux de réponse , Total des enquêtes <?= count($responseTrue) + count($responseFalse); ?>"],
        datasets: [{
          label: "Répondu",
          data: [<?= count($responseTrue); ?>],
          backgroundColor: "rgba(0,255,0,0.2)"
        }, {
          label: "En attente",
          data: [<?= count($responseFalse); ?>],
          backgroundColor: "rgba(255,0,0,0.4)"
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });

    var ctx = document.getElementById('myChart2').getContext('2d');
    var myChart2 = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ["Bon", "Moyen", "Mauvais"],
        datasets: [{
          label: "Population (millions)",
          backgroundColor: ["rgba(0,255,0,0.2)", "rgba(255, 180, 67,0.7)", "rgba(255,0,0,0.4)"],
          borderWidth: 0,

          data: [<?= count($goodRate); ?>, <?= count($mediumRate); ?>, <?= count($badRate); ?>, ]
        }]
      },
      options: {
        title: {
          display: true,
          text: 'Taux de satisfaction , Total de réponse <?= count($responseTrue); ?>'
        }
      }
    });


    var myChart3 = new Chart('myChart3', {
  type: 'horizontalBar',
  data: {
        labels: [<?="'".implode("','",$top5)."'";?>],
        datasets: [{
          label: "Meilleur taux de satisfaction",
          backgroundColor: ["rgba(0,255,0,0.2)", "rgba(255, 180, 67,0.7)", "rgba(255,0,0,0.4)", "rgba(0,0,255,0.4)", "rgba(112,0,122,0.4)"],
          borderWidth: 0,

          data: [<?= "'".implode("','",$topNote)."'";?>]
        }]
      },
  options: {
    scales: {
      xAxes: [{
        ticks: {
          beginAtZero: true
        }

      }]
    }
  }
});
  </script>

</body>

</html>