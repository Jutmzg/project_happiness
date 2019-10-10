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
<!DOCTYPE html>
<html lang="en">
<?php require '../layout/header.php'; ?>
<div class="container">
  <div class="card mt-5">
    <div class="card-header">
      <h2>Missions</h2>
      <a href="/Akkappiness/mission/create.php"><button type="button" class="btn btn-primary"><i class="fas fa-user-plus"></i></button></a>
      
      <input type="text" class="form-control col-3" id="filter-text-box" placeholder="Rechercher" oninput="onFilterTextBoxChanged()" />
      <div id="myGrid" style="height: 600px;width:100%;" class="ag-theme-balham"></div>

      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Mission</th>
              <th>Client</th>
              <th>Consultant</th>
              <th>Poste</th>
              <th>Début de la mission</th>
              <th>Fin de la mission</th>
              <th>Action</th>
            </tr>
          </thead>
          <?php foreach ($mission as $row) : ?>
            <tr>
              <td data-label="Mission"><?= $row->mission; ?></td>
              <td data-label="Client"><?= $row->customer; ?></td>
              <td data-label="Consultant"><?= $row->consultant; ?></td>
              <td data-label="Poste"><?= $row->job; ?></td>
              <td data-label="Début de la mission"><?= date("d/m/Y", strtotime($row->start)); ?></td>
              <td data-label="Fin de la mission"><?= date("d/m/Y", strtotime($row->stop)); ?></td>
              <td data-label="Action">
                <a href="edit.php?id=<?= $row->ID ?>" class="btn btn-info"><i class="fas fa-user-edit fa-xs"></i></a>
                <a onclick="return confirm('Etes vous sur de vouloir effectuer la suppression?')" href="delete.php?id=<?= $row->ID ?>" class='btn btn-danger '><i class="fas fa-trash-alt"></i></a>
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

  const PRODUCTS_ACTIONS_TEMPLATE =
    `
<a href="edit.php?id=1" class="btn btn-info"><i class="fas fa-user-edit fa-xs"></i></a>
                <a onclick="return confirm('Etes vous sur de vouloir effectuer la suppression?')" href="delete.php?id=1" class='btn btn-danger'><i class="fas fa-trash-alt"></i></a>`;


  var columnDefs = [{
      headerName: "Mission",
      field: "mission",
      sortable: true,
      filter: true,

    },
    {
      headerName: "Client",
      field: "customer",
      sortable: true,
      filter: true,
    },
    {
      headerName: "Consultant",
      field: "consultant",
      sortable: true,
      filter: true,
    },
    {
      headerName: "Poste",
      field: "job",
      sortable: true,
      filter: true,
    },
    {
      headerName: "Début de mission",
      field: "start",
      sortable: true,
      filter: true,
    },
    {
      headerName: "Fin de mission",
      field: "stop",
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
    <?php foreach ($mission as $row) { ?>

      {
        mission: "<?= $row->mission ?>",
        customer: "<?= $row->customer ?>",
        consultant: "<?= $row->consultant ?>",
        job: "<?= $row->job ?>",
        start: "<?= $row->start ?>",
        stop: "<?= $row->stop ?>",
        action: `<a href="edit.php?id=1" class="btn btn-info"><i class="fas fa-user-edit fa-xs"></i></a>
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