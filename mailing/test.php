<!--

SELECT c.mail, e.mission_id FROM enquete e
JOIN mission m 
ON m.id = e.mission_id
JOIN consultant c
ON c.id = m.consultant_id
WHERE e.mission_id = $mission_id
AND c.mail = $mail

-->

<!DOCTYPE html>
<html lang="fr">
<link href="../assets/fontawesome/css/all.css" rel="stylesheet">


<head>
  <title>Akkappiness</title>
</head>

<body>
  <div class="container">
  <h1>Bonjour,</h1>
  <p>Dans le cadre de notre campagne d’enquête de satisfaction, merci de nous donner votre niveau de satisfaction de votre mission actuelle.
En vous remerciant par avance</p>
    <div class="row col-12">
      <a href="1.php?id=467" title="Bien"><i class="far fa-smile fa-5x"></i></a>
      <a href="2.php?id=467" title="Moyen"><i class="far fa-meh fa-5x"></i></a>
      <a href="3.php?id=467" title="Mauvais"><i class="far fa-frown fa-5x"></i></a>
    </div>
  </div>
</body>

</html>