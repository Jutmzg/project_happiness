<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php'; 

$sql = 'SELECT id, name FROM job ORDER BY name';
$statement = $connection->prepare($sql);
$statement->execute();
$jobs = $statement->fetchAll(PDO::FETCH_OBJ);

$message = '';

if (
  isset($_POST['name']) 
) {

  $name = $_POST['name'];

  $sql = 'INSERT INTO job(name) VALUES(:name)';
  $statement = $connection->prepare($sql);
  if ($statement->execute([':name' => $name])) {
    $message = '<i class="far fa-check-circle"></i>
    Métier enregistré';
  }
}
?>

<body>
  <div class="container">
    <div class="card mt-4">
      <div class="card-header">
        <h2 class="text-center text-uppercase">Postes</h2>

        <div class="add d-flex">
        <div class="bouton">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add" data-whatever="@mdo"><i class="fas fa-plus"></i></button>
        <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-body">
              <form method="post">
                <a onclick="goBack()"><span aria-hidden="true">&times;</span></a>

          <div class="input-box">
          <input type="text" name="name" id="name" placeholder="Nom" maxlength="50" minlength="2" required>
        </div>

        <div class="form-group">
          <div class="input-box">
          <button type="submit" class="btn btn-info">Valider</button>
          <button class="btn btn-info retour"><a onclick="goBack()">Annuler</a></button>

        </div>
        </div>
      </form>
                <p id="result"></p>
              </div>
            </div>
          </div>
        </div>
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
        width: 910,
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
          nom: "<?=$job->name ?>",
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
        "<a href=delete.php?id=" + action + " class='btn btn-danger'><i class='fas fa-trash-alt'></i></a>";
    }

    function edit() {
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