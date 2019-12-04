<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php';

// INSERTION

$message = '';

if (
  isset($_POST['name']) &&
  isset($_POST['address'])
) {

  $name = $_POST['name'];
  $address = $_POST['address'];
  $state = 0;

  $sql = 'INSERT INTO customer(name, address, state) VALUES(:name, :address, :state)';
  $statement = $connection->prepare($sql);
  if ($statement->execute([':name' => $name, ':address' => $address, ':state' => $state])) {
    $message = ' Client enregistré';
  }
}
// SUPPRESSION 
if (
  isset($_GET['id'])
) {
  $ids = explode(',', $_GET['id']);

  if ($id == "") {
    header('Location: /customer/show.php');
  }
  foreach ($ids as $id) {
    $sql = 'UPDATE customer SET state = 1 WHERE id=:id';
    $statement = $connection->prepare($sql);
    if ($statement->execute([':id' => $id])) {
      header("Location: show.php");
    }
  }
}

if ($message !== '') {
  echo "<div class='alert alert-success'><i class='far fa-check-circle'></i>$message</div>";
}
$sql = 'SELECT id, name, address FROM customer WHERE state = 0 ORDER BY name';
$statement = $connection->prepare($sql);
$statement->execute();
$customers = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<body>
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="popUpBox">
        <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times" id="cross"></i></button>
        <h4 class="modal-title text-center">AJOUT D'UN CLIENT</h4>
        <div class="modal-content">
          <form method="post">
            <div class="input-box">
              <input type="text" placeholder="Nom" name="name" id="name" maxlength="50" minlength="2" required>
            </div>
            <div class="input-box">
              <input type="text" placeholder="Adresse" name="address" id="address" maxlength="75" minlength="10" required>
            </div>

            <div class="form-group">
              <div class="input-box">
                <div class="ValAnn">
                  <button type="submit" class="btn btn-info">Valider</button>
                  <a href="/customer/show.php" class="btn btn-info">Annuler</a>
                </div>

              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="card mt-4">
      <div class="card-header">
        <h2 class="text-center text-uppercase">Clients</h2>

        <div class="add d-flex">
          <div class="bouton">
            <button type="button" class='btn btn-primary mr-1' data-toggle="modal" data-target="#myModal"><i class="fas fa-plus"></i></button>
            <div id="edit"></div>
            <div id="delete" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce client ?')"></div>
          </div>
        </div>
        <div class="card-body">
          <input type="text" class="form-control col-3" id="filter-text-box" placeholder="Rechercher" oninput="onFilterTextBoxChanged()" />
          <div id="myGrid" class="ag-theme-balham" onclick="buttons()" ondblclick="edit()"></div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
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
      <?php foreach ($customers as $customer) { ?> {
          nom: "<?= $customer->name ?>",
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
      document.getElementById("edit").innerHTML =
        "<a href=edit.php?id=" + action + " class='btn btn-info'><i class='fas fa-pencil-alt'></i></a>";
      document.getElementById("delete").innerHTML =
        "<a href=show.php?id=" + action + " class='btn btn-danger'><i class='fas fa-trash-alt'></i></a>";
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