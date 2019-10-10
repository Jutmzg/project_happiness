﻿<?php
require '../db/db.php';

$sql = "SELECT c.id, CONCAT(c.firstname,' ', c.lastname) as fullname, 
c.mail, CONCAT(mana.firstname,' ',mana.lastname) manager, m.name mission 
FROM consultant c
JOIN manager mana 
ON c.manager_id = mana.id
LEFT JOIN mission m
ON c.mission_id = m.id
WHERE c.state = 0";
$statement = $connection->prepare($sql);
$statement->execute();
$consultants = $statement->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php'; ?>

<div class="container">
  <div class="card mt-4">
    <div class="card-header">

      <h2 class="text-center text-uppercase">Consultants</h2>
      <a href="/Akkappiness/consultant/create.php"><button type="button" class="btn btn-primary ml-4"><i class="fas fa-user-plus"></i></button></a>
      <div id="editAndDelete"></div>
      <div class="card-body">
        <input type="text" class="form-control col-3" id="filter-text-box" placeholder="Rechercher" oninput="onFilterTextBoxChanged()" />
        <div id="myGrid" class="ag-theme-balham" onclick="buttons()"></div>
      </div>
    </div>
  </div>
</div>
</head>

<body>

  <script type="text/javascript" charset="utf-8">
    var columnDefs = [{
        headerName: "Nom",
        field: "nom",
        sortable: true,
        filter: true,
        width: 250,
        suppressSizeToFit: true,

      },
      {
        headerName: "Email",
        field: "mail",
        sortable: true,
        filter: true,
        width: 250,
      },
      {
        headerName: "Mission",
        field: "mission",
        sortable: true,
        filter: true,
        width: 250,
      },
      {
        headerName: "Manager",
        field: "manager",
        sortable: true,
        filter: true,
        width: 250,
        
      },
      {
        headerName: "Action",
        field: 'action',
        hide: true,
        width: 250,

      },

    ];
    // specify the data
    var rowData = [
      <?php foreach ($consultants as $consultant) { ?> {
        nom: "<?= utf8_encode($consultant->fullname) ?>",
        mail: "<?= $consultant->mail ?>",
        mission: "<?= utf8_encode($consultant->mission) ?>",
        manager: "<?= utf8_encode($consultant->manager) ?>", 
        action:   "<?= $consultant->id ?>",
        },
      <?php } ?>

    ];
    var gridOptions = {
      defaultColDef: {
        resizable: true,
        suppressColumnVirtualisation: true,
      },
      columnDefs: columnDefs,
      pagination: true,
      paginationPageSize: 20,
      rowData: rowData,
      rowSelection: 'multiple',
      headerHeight: 50,
      // hauteur des rows
      getRowHeight: function(params) {
        return 60;
      },
    };

    var eGridDiv = document.querySelector('#myGrid');
    new agGrid.Grid(eGridDiv, gridOptions);

    function onFilterTextBoxChanged() {
      gridOptions.api.setQuickFilter(document.getElementById('filter-text-box').value);
    }

    function buttons() {
      var selectedNodes = gridOptions.api.getSelectedNodes()
      var selectedData = selectedNodes.map(function(node) {
        return node.data
      })
      var action = selectedData.map(function(node) {
        return node.action
      })
      document.getElementById("editAndDelete").innerHTML =
        "<a href=edit.php?id=" + action + " class='btn btn-info'><i class='fas fa-user-edit fa-xs'></i></a> <a 'onclick=return confirm('Etes vous sur de vouloir effectuer la suppression?)' href=delete.php?id=" + action + " class='btn btn-danger'><i class='fas fa-trash-alt'></i></a>";

    }
  </script>
  <?php require '../layout/footer.php'; ?>