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

?>





<head>
    <script src="../assets/js/Chart.min.js"></script>


</head>

<body>
    <h2 class="text-center p-4 welcome">BIENVENUE SUR AKKAPPINESS</h2>
    <div class="container d-flex justify-content-between">
        <div class="row col-md-5 col-lg-5 col-sm-12 p-2">
            <canvas id="myChart1" width="400" height="400"></canvas>
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
      backgroundColor:"rgba(255,0,0,0.3)"
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
    </script>

    
</body>
<?php require '../layout/footer.php'; ?>

</html>