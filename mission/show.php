<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php';

$sql = "SELECT m.ID, m.name mission,c.name customer, CONCAT(cons.lastname,' ', cons.firstname) as consultant, j.name job, m.start, m.stop, m.state 
FROM mission m
LEFT JOIN consultant cons ON m.consultant_id = cons.ID
INNER JOIN customer c ON m.customer_id = c.ID
INNER JOIN job j ON m.job_id = j.ID
WHERE m.state = 0
ORDER BY consultant ASC";
$statement = $connection->prepare($sql);
$statement->execute();
$mission = $statement->fetchAll(PDO::FETCH_OBJ);

?>

<body>
  <div class="container">
    <div class="card mt-4">
      <div class="card-header">
        <h2 class="text-center text-uppercase">Missions</h2>
        <div class="add d-flex">
          <a href="/Akkappiness/mission/create.php" class='btn btn-primary mr-1'><i class="fas fa-plus"></i></a>
          <div id="editAndDelete"></div>
        </div>
        <div class="card-body">
          <input type="text" class="form-control col-3" id="filter-text-box" placeholder="Rechercher" oninput="onFilterTextBoxChanged()" />
          <div id="myGrid" class="ag-theme-balham" onclick="buttons()" ondblclick="edit()"></div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript" charset="utf-8">
    var columnDefs = [{
        headerName: "Nom",
        field: "mission",
        sortable: true,
        filter: true,
        width: 140,
        suppressSizeToFit: true,

      },
      {
        headerName: "Client",
        field: "customer",
        sortable: true,
        filter: true,
        width: 150,
      },
      {
        headerName: "Consultant",
        field: "consultant",
        sortable: true,
        filter: true,
        width: 167,
      },
      {
        headerName: "Poste",
        field: "job",
        sortable: true,
        filter: true,
        width: 167,
      },
      {
        headerName: "Début de mission",
        field: "start",
        sortable: true,
        filter: true,
        width: 140,
      },
      {
        headerName: "Fin de mission",
        field: "stop",
        sortable: true,
        filter: true,
        width: 140,
      },
      {
        headerName: "Action",
        field: 'action',
        hide: true,
        width: 250,
      },
    ];
    var rowData = [
      <?php foreach ($mission as $row) { ?>

        {
          mission: "<?= utf8_encode($row->mission) ?>",
          customer: "<?= utf8_encode($row->customer) ?>",
          consultant: "<?= utf8_encode($row->consultant) ?>",
          job: "<?= utf8_encode($row->job) ?>",
          start: "<?= date('d/m/Y', strtotime($row->start)) ?>",
          stop: "<?= date('d/m/Y', strtotime($row->stop)) ?>",
          action: "<?= $row->ID ?>",
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
        "<a href=edit.php?id=" + action + " class='btn btn-info'><i class='fas fa-pencil-alt'></i></a> <a 'onclick=return confirm('Etes vous sur de vouloir effectuer la suppression?)' href=delete.php?id=" + action + " class='btn btn-danger'><i class='fas fa-trash-alt'></i></a>";
    }

    function edit() {
      let selectedNodes = gridOptions.api.getSelectedNodes()
      let selectedData = selectedNodes.map(function(node) {
        return node.data
      })
      let action = selectedData.map(function(node) {
        return node.action
      })
      var edit = 'edit.php?id=' + action;
      window.location = edit;
    }
  </script>
</body>
<?php require '../layout/footer.php'; ?>

</html>