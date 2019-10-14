<?php require_once('../connection.php'); ?>

<head>
  <title>AKKAPPINESS</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, user-scalable=no">


  <link href="https://unpkg.com/izitoast/dist/css/iziToast.min.css" rel="stylesheet">
  
  <link href="../assets/fontawesome/css/all.css" rel="stylesheet">
  <link href="../assets/aggrid/ag-grid.css" rel="stylesheet">
  <link href="../assets/aggrid/ag-theme-balham.css" rel="stylesheet">
  <link href="../assets/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
  <script src="../assets/jquery/jquery-3.4.1.min.js"></script>
  <script src="../assets/jquery-ui/jquery-ui.min.js"></script>
  <script src="../assets/aggrid/ag-grid-community.min.noStyle.js"></script>

  <script src="https://unpkg.com/izitoast/dist/js/iziToast.min.js"></script>
</head>

<header>
  <nav class="navbar navbar-expand-lg navbar-light bg-light text-uppercase p-1">
    <a class="navbar-brand" href="/Akkappiness/home/index.php"><img src='../assets/img/logo.png' alt="logo"> </a>
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
        <a class="nav-link mr-2" href="/Akkappiness/export/export.php">Export</a>
        </li>
      </ul>
    </div>
  </nav>
</header>
