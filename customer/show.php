<?php
require '../db/db.php';
$sql = 'SELECT ID,name, address FROM customer WHERE state = 0';
$statement = $connection->prepare($sql);
$statement->execute();
$customers = $statement->fetchAll(PDO::FETCH_OBJ);

?>
<?php require '../layout/header.php'; ?>
<div class="container">
  <div class="card mt-5">
    <div class="card-header">
      <h2>Clients</h2>
      <a href="/Akkappiness/customer/create.php"><button type="button" class="btn btn-primary"><i class="fas fa-user-plus"></i></button></a>
    
      <input type="text" class="form-control col-3" id="filter-text-box" placeholder="Rechercher" oninput="onFilterTextBoxChanged()" />

<div id="myGrid" style="height: 600px;width:100%;" class="ag-theme-balham"></div>
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Adresse</th>
            <th>Action</th>
          </tr>
        </thead>
        <?php foreach ($customers as $customer) : ?>
          <tr>
            <td data-label="Nom"><?= $customer->name; ?></td>
            <td data-label="Adresse"><?= $customer->address; ?></td>
            <td data-label="Action">
              <a href="edit.php?id=<?= $customer->ID ?>" class="btn btn-info"><i class="fas fa-user-edit fa-xs"></i></a>
              <a onclick="return confirm('Etes vous sur de vouloir effectuer la suppression?')" href="delete.php?id=<?= $customer->ID ?>" class='btn btn-danger'><i class="fas fa-trash-alt"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
</div>


<script type="text/javascript" charset="utf-8">
  // specify the columns 

  const PRODUCTS_ACTIONS_TEMPLATE = 
    `
<a href="edit.php?id=1" class="btn btn-info"><i class="fas fa-user-edit fa-xs"></i></a>
                <a onclick="return confirm('Etes vous sur de vouloir effectuer la suppression?')" href="delete.php?id=1" class='btn btn-danger'><i class="fas fa-trash-alt"></i></a>`;


  var columnDefs = [{
      headerName: "Nom",
      field: "nom",
      sortable: true,
      filter: true,

    },
    {
      headerName: "Adresse",
      field: "adresse",
      sortable: true,
      filter: true,
    },
    {
      headerName: "Action",
      field: 'action',
     // template: PRODUCTS_ACTIONS_TEMPLATE,
      
    },
    
  ];
  // specify the data
  var rowData = [
    <?php foreach ($customers as $customer) { ?>

      {
        nom: "<?= $customer->name ?>",
        adresse: "<?= $customer->address ?>",
        action:   `<a href="edit.php?id=1" class="btn btn-info"><i class="fas fa-user-edit fa-xs"></i></a>
                <a onclick="return confirm('Etes vous sur de vouloir effectuer la suppression?')" href="delete.php?id=1" class='btn btn-danger'><i class="fas fa-trash-alt"></i></a>;`,
      },

    <?php } ?>

  ];
  // let the grid know which columns and what data to use
  var gridOptions = {

    columnDefs: columnDefs,
    pagination: true,
    rowData: rowData,
    rowSelection: 'multiple',
    headerHeight: 50,
    floatingFiltersHeight: 50,
    pivotGroupHeaderHeight: 50,
    piotGroupHeaderHeight: 50,
    // hauteur des rows
    getRowHeight: function(params) {
      return 80;
    },
  };

 
  var eGridDiv = document.querySelector('#myGrid');

  new agGrid.Grid(eGridDiv, gridOptions);

  function getSelectedRows() {
    var selectedNodes = gridOptions.api.getSelectedNodes()
    var selectedData = selectedNodes.map(function(node) {
      return node.data
    })
    var mail = selectedData.map(function(node) {
      return node.mail
    }).join('<br>')
    document.getElementById("mailing").innerHTML = mail;

  }

  function onFilterTextBoxChanged() {
    gridOptions.api.setQuickFilter(document.getElementById('filter-text-box').value);
  }
</script>
<?php require '../layout/footer.php'; ?>