<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php';

// INSERTION
if (
  isset($_POST['name'])
) {
  $name = $_POST['name'];

  $sql = 'INSERT INTO job(name) VALUES(:name)';
  $statement = $connection->prepare($sql);
  if ($statement->execute([':name' => $name])) {
    $message = urlencode('<div class="alert alert-success"><i class="far fa-check-circle"></i> Métier ajouté</div>');
    header("Location:show.php?Message=".$message);

  }
}
// SUPPRESSION 
if (
  isset($_GET['id'])
) {
  $ids = explode(',', $_GET['id']);

  if ($id == "") {
    header('Location: /job/show.php');
  }
  foreach ($ids as $id) {
    $sql = 'DELETE FROM job WHERE id=:id';
    $statement = $connection->prepare($sql);
    if ($statement->execute([':id' => $id])) {
      header("Location: show.php");
    }
  }
}
if(isset($_GET['Message'])){
  echo $_GET['Message'];
}



// AFFICHAGE
$sql = 'SELECT id, name FROM job ORDER BY name';
$statement = $connection->prepare($sql);
$statement->execute();
$jobs = $statement->fetchAll(PDO::FETCH_OBJ);

?>

<body>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="popUpBox">
      <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times" id="cross"></i></button>
      <h4 class="modal-title text-center">CREATION D'UN POSTE</h4>
      <div class="modal-content">
      <form method="post">
          <div class="input-box">

            <input type="text" name="name" id="name" placeholder="Nom" maxlength="50" minlength="2" required>
          </div>
          <div class="ValAnn">
                  <button type="submit" class="btn btn-info">Valider</button>
                  <a href="/job/show.php" class="btn btn-info">Annuler</a>
              </div>
        </form>
      </div>
    </div>
  </div>
</div>

  <div class="container">
    <div class="card mt-4">
      <div class="card-header">
        <h2 class="text-center text-uppercase">Postes</h2>
        <div class="alert alert-success alert-dismissible" id="success" style="display:none;"></div>
        <div class="add d-flex">
          <div class="bouton">
            <button type="button" class='btn btn-primary mr-1' data-toggle="modal" data-target="#myModal"><i class="fas fa-plus"></i></button>
            <div id="edit"></div>
            <div id="delete" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce poste ?')"></div>
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
        width: 905,
        suppressSizeToFit: true,
      },
      {
        headerName: "Action",
        field: 'action',
        hide: true,
      },
    ];

    var rowData = [
      <?php foreach ($jobs as $job) { ?> {
          nom: "<?= $job->name ?>",
          action: "<?= $job->id ?>",
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
