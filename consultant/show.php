<?php
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

<?php require '../layout/header.php'; ?>

<button class="btn btn-primary" onclick="getSelectedRows()">-></button>

<div class="container">
  <div class="card mt-5">
    <div class="card-header">

      <h2>Consultants</h2>
      <a href="/Akkappiness/consultant/create.php"><button type="button" class="btn btn-primary"><i class="fas fa-user-plus"></i></button></a>
      <div class="card-body">
<?php $loupe ="fas fa-search"?>


        <input type="text" class="form-control col-3" id="filter-text-box" placeholder="<i class=<?=$loupe?></i>"onFilterTextBoxChanged()/>
        <div id="myGrid" style="height: 600px;width:100%;" class="ag-theme-balham"></div>



        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Email</th>
              <th>Mission</th>
              <th>Manager</th>
              <th>Action</th>

            </tr>
          </thead>
          <?php foreach ($consultants as $consultant) : ?>
            <tr>
              <td data-label="Nom"><?= $consultant->fullname; ?></td>
              <td data-label="Email"><?= $consultant->mail; ?></td>
              <td data-label="Mission"><?= $consultant->mission ?></td>
              <td data-label="Manager"><?= $consultant->manager ?></td>

              <td data-label="Action">
                <a href="edit.php?id=<?= $consultant->id ?>" class="btn btn-info"><i class="fas fa-user-edit fa-xs"></i></a>
                <a onclick="return confirm('Etes vous sur de vouloir effectuer la suppression?')" href="delete.php?id=<?= $consultant->id ?>" class='btn btn-danger'><i class="fas fa-trash-alt"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript" charset="utf-8">
  // specify the columns

  const PRODUCTS_ACTIONS_TEMPLATE = `
  <a href="edit.php?id=<?= $consultant->id ?>" class="btn btn-info"><i class="fas fa-user-edit fa-xs"></i></a>
                <a onclick="return confirm('Etes vous sur de vouloir effectuer la suppression?')" href="delete.php?id=<?= $consultant->id ?>" class='btn btn-danger'><i class="fas fa-trash-alt"></i></a>`;

  var columnDefs = [{
      headerName: "Nom",
      field: "nom",
      sortable: true,
      filter: true,

    },
    {
      headerName: "Email",
      field: "mail",
      sortable: true,
      filter: true,
    },
    {
      headerName: "Mission",
      field: "mission",
      sortable: true,
      filter: true,
    },
    {
      headerName: "Manager",
      field: "manager",
      sortable: true,
      filter: true,
    },
    {
      headerName: "Action",
      field: '',
      template: PRODUCTS_ACTIONS_TEMPLATE,
      minWidth: 80,
      maxWidth: 80,

    },
  ];
  // specify the data
  var rowData = [
    <?php foreach ($consultants as $consultant) { ?>

      {
        nom: "<?= $consultant->fullname ?>",
        mail: "<?= $consultant->mail ?>",
        mission: "<?= $consultant->mission ?>",
        manager: "<?= $consultant->manager ?>",
        action: "bouton"
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