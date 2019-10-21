<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php'; 

$sql = 'SELECT id, name, address FROM customer WHERE state = 0 ORDER BY name';
$statement = $connection->prepare($sql);
$statement->execute();
$customers = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<body>
<div class="container">
  <div class="card mt-4">
    <div class="card-header">
    <h2 class="text-center text-uppercase">Clients</h2>

      <div class="add d-flex">
        <a href="/Akkappiness/customer/create.php" class='btn btn-primary mr-1'><i class="fas fa-plus"></i></a>
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
      field: "nom",
      sortable: true,
      filter: true,
      width: 450,
      suppressSizeToFit: true,
    },
    {
      headerName: "Adresse",
      field: "adresse",
      sortable: true,
      filter: true,
      width: 450,

    },
    {
      headerName: "Action",
      field: 'action',
      hide: true,
    },
  ];

  var rowData = [
    <?php foreach ($customers as $customer) { ?>
      {
        nom: "<?= utf8_encode($customer->name) ?>",
        adresse: "<?= $customer->address ?>",
        action: "<?= $customer->id ?>",
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
        "<a href=edit.php?id=" + action + " class='btn btn-info'><i class='fas fa-pencil-alt'></i></a> <a 'onclick=return confirm('Etes vous sur de vouloir effectuer la suppression?)' href=delete.php?id=" + action + " class='btn btn-danger'><i class='fas fa-trash-alt'></i></a>";
    }

    function edit(){
        let selectedNodes = gridOptions.api.getSelectedNodes()
        let selectedData = selectedNodes.map(function(node) {
          return node.data
        })
        let action = selectedData.map(function(node) {
          return node.action
        })
        var edit = 'edit.php?id='+action;
        window.location= edit;
        }
  </script>
</body>
<?php require '../layout/footer.php'; ?>
</html>