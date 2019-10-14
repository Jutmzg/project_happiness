<!--

SELECT c.mail, e.mission_id FROM enquete e
JOIN mission m 
ON m.id = e.mission_id
JOIN consultant c
ON c.id = m.consultant_id
WHERE e.mission_id = $mission_id
AND c.mail = $mail



SELECT c.mail, e.mission_id FROM enquete e
JOIN mission m 
ON m.id = e.mission_id
JOIN consultant c
ON c.id = m.consultant_id
WHERE e.state = 1
 -->
<!DOCTYPE html>
<html lang="fr">
<link href="../assets/fontawesome/css/all.css" rel="stylesheet">


<head>
  <title>Akkappiness</title>
</head>

<body>
  <h1>Bonjour</h1>
  <div class="container">
    <div class="row col-12">
      <a href="1.php?mission_id=3" title="Bien"><i class="far fa-smile fa-5x"></i></a>
      <a href="2.php?mission_id=3" title="Moyen"><i class="far fa-meh fa-5x"></i></a>
      <a href="3.php?mission_id=3" title="Mauvais"><i class="far fa-frown fa-5x"></i></a>
    </div>
  </div>
</body>

</html>