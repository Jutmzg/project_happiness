<?php
require '../db/db.php';
$sql = "SELECT m.ID, m.name mission,c.name customer, CONCAT(cons.firstname,' ', cons.lastname) as consultant, j.name job, m.start, m.stop, m.state FROM mission m
LEFT JOIN consultant cons ON m.consultant_id = cons.ID
INNER JOIN customer c ON m.customer_id = c.ID
INNER JOIN job j ON m.job_id = j.ID
WHERE m.state = 0";
$statement = $connection->prepare($sql);
$statement->execute();
$mission = $statement->fetchAll(PDO::FETCH_OBJ);

?>
<?php require '../layout/header.php'; ?>

<div class="container">
  <div class="card mt-4">
    <div class="card-header">
    <h2 class="text-center text-uppercase">Missions</h2>
      <a href="/Akkappiness/mission/create.php"><button type="button" class="btn btn-primary ml-4"><i class="fas fa-user-plus"></i></button></a>
      <div id="editAndDelete"></div>
      <div class="card-body">
        <input type="text" class="form-control col-3" id="filter-text-box" placeholder="Rechercher" oninput="onFilterTextBoxChanged()" />
        <div id="myGrid" style="height: 600px;width:100%;" class="ag-theme-balham" onclick="buttons()"></div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" charset="utf-8">
  
  var columnDefs = [{
      headerName: "Mission",
      field: "mission",
      sortable: true,
      filter: true,
      width: 167,
      suppressSizeToFit: true,

    },
    {
      headerName: "Client",
      field: "customer",
      sortable: true,
      filter: true,
      width: 167,
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
      width: 167,
    },
    {
      headerName: "Fin de mission",
      field: "stop",
      sortable: true,
      filter: true,
      width: 167,
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
        mission: "<?= $row->mission ?>",
        customer: "<?= $row->customer ?>",
        consultant: "<?= $row->consultant ?>",
        job: "<?= $row->job ?>",
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
        "<a href=edit.php?id=" + action + " class='btn btn-info'><i class='fas fa-user-edit fa-xs'></i></a> <a 'onclick=return confirm('Etes vous sur de vouloir effectuer la suppression?)' href=delete.php?id=" + action + " class='btn btn-danger'><i class='fas fa-trash-alt'></i></a>";
    }
  </script>

<?php require '../layout/footer.php'; ?>