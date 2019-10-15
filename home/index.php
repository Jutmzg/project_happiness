<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php'; ?>

<?php
$sql = "SELECT * FROM `enquete` WHERE state = 0";
$statement = $connection->prepare($sql);
$statement->execute();
$responseTrue = $statement->fetchAll(PDO::FETCH_OBJ);

$sql = "SELECT * FROM `enquete` WHERE state = 1";
$statement = $connection->prepare($sql);
$statement->execute();
$responseFalse = $statement->fetchAll(PDO::FETCH_OBJ);

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

?>

<head>
    <script src="../assets/js/Chart.min.js"></script>
</head>
<body>
    <h2 class="text-center p-4 welcome">BIENVENUE SUR AKKAPPINESS</h2>
    <div class="container">
        <div class="col-md-5 col-lg-6 col-sm-12 d-flex justify-center">
            <canvas id="myChart1" width="400" height="400"></canvas>
            <canvas id="myChart2" width="400" height="400"></canvas>

        </div>

    </div>

    <script>
        var ctx = document.getElementById('myChart1').getContext('2d');
        var myChart1 = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Taux de réponse , Total des enquêtes <?=count($responseTrue) + count($responseFalse);?>"],
    datasets: [{
      label: "Répondu",
      data: [<?=count($responseTrue);?>],
      backgroundColor:"rgba(0,255,0,0.2)"
    }, {
      label: "En attente",
      data: [<?=count($responseFalse);?>],
      backgroundColor:"rgba(255,0,0,0.4)"
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
        var myChart2     = new Chart(ctx, {
            type: 'doughnut',
    data: {
      labels: ["Bon", "Moyen", "Mauvais"],
      datasets: [
        {
          label: "Population (millions)",
          backgroundColor: ["rgba(0,255,0,0.2)","rgba(255, 180, 67,0.7)","rgba(255,0,0,0.4)"],
          borderWidth: 0, 
          
          data: [<?=count($goodRate);?>,<?=count($mediumRate);?>,<?=count($badRate);?>,]
        }
      ]
    },
    options: {
      title: {
        display: true,
        text: 'Taux de satisfaction , Total de réponse <?=count($responseTrue);?>'
            }    
      }
        });
    </script>

    
</body>


<?php require '../layout/footer.php'; ?>

</html>