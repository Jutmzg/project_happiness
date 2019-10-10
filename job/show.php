<?php
require '../db/db.php';
$sql = 'SELECT * FROM job';
$statement = $connection->prepare($sql);
$statement->execute();
$jobs = $statement->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<?php require '../layout/header.php'; ?>
<div class="container">
  <div class="card mt-4">
    <div class="card-header">
    <h2 class="text-center text-uppercase">Métiers</h2>
      <a href="/Akkappiness/job/create.php"><button type="button" class="btn btn-primary ml-4"><i class="fas fa-user-plus"></i></button></a>
      <div id="editAndDelete"></div>
      <div class="card-body">
        <input type="text" class="form-control col-3" id="filter-text-box" placeholder="Rechercher" oninput="onFilterTextBoxChanged()" />
        <div id="myGrid" class="ag-theme-balham" onclick="buttons()"></div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript" charset="utf-8">

  var columnDefs = [{
      headerName: "Nom",
      field: "nom",
      sortable: true,
      filter: true,
      width: 1000,
      suppressSizeToFit: true,
    },
    {
      headerName: "Action",
      field: 'action',
      hide: true,
    },
  ];

  var rowData = [
    <?php foreach ($jobs as $job) { ?>
      {
        nom: "<?= $job->name ?>",
        action: "<?= $job->ID ?>",
      },

    <?php } ?>

  ];
  var gridOptions = {

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