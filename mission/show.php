<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php';

// INSERTION 

$sql2 = 'SELECT * FROM job ORDER BY name';
$statement = $connection->query($sql2);
$statement->execute();
$jobs = $statement->fetchAll(PDO::FETCH_OBJ);

$sql = 'SELECT * FROM customer WHERE state = 0 ORDER BY name';
$statement = $connection->query($sql);
$statement->execute();
$customers = $statement->fetchAll(PDO::FETCH_OBJ);

$sql3 = "SELECT id, CONCAT(lastname,' ', firstname) as fullname FROM consultant WHERE state = 0 ORDER BY fullname";
$statement = $connection->query($sql3);
$statement->execute();
$consultants = $statement->fetchAll(PDO::FETCH_OBJ);

if (
  isset($_POST['name']) &&
  isset($_POST['customer_id']) &&
  isset($_POST['job']) &&
  isset($_POST['consultant_id']) &&
  isset($_POST['start']) &&
  isset($_POST['stop'])
) {
  $name = $_POST['name'];
  $customer_id = $_POST['customer_id'];
  $job_id = $_POST['job'];
  $consultant_id = $_POST['consultant_id'];
  $start = date('Y-m-d', strtotime($_POST['start']));
  $stop = date('Y-m-d', strtotime($_POST['stop']));
  $state = 0;

  $sql = 'INSERT INTO mission(name, customer_id, job_id, consultant_id, start, stop,state) VALUES(:name, :customer_id, :job_id, :consultant_id, :start, :stop, :state)';
  $statement = $connection->prepare($sql);
  if ($statement->execute([':name' => $name, ':customer_id' => $customer_id, ':job_id' => $job_id, ':consultant_id' => $consultant_id, ':start' => $start, ':stop' => $stop, ':state' => $state])) {
    $message = urlencode('<div class="alert alert-success"><i class="far fa-check-circle"></i> Mission ajoutée</div>');
    header("Location:show.php?Message=".$message);
  }
}

// SUPPRESSION 
if (
  isset($_GET['id'])
) {
  $ids = explode(',', $_GET['id']);

  if ($id == "") {
    header('Location: /Akkappiness/mission/show.php');
  }
  foreach ($ids as $id) {
    $sql = 'UPDATE mission SET state = 1 WHERE id=:id';
    $statement = $connection->prepare($sql);
    if ($statement->execute([':id' => $id])) {
      header("Location: show.php");
    }
  }
}

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
if(isset($_GET['Message'])){
  echo $_GET['Message'];
}
?>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="popUpMission">
      <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times" id="cross"></i></button>
      <h4 class="modal-title text-center">CREATION D'UNE MISSION</h4>
      <div class="modal-content">

        <form method="post" id="monFormulaire">
          <div class="input-box">
            <input value="<?php $cons; ?>" type="text" placeholder="Nom" name="name" id="name" maxlength="50" minlength="2" required readonly>
          </div>

          <div class="input-box">

            <select id="consultant" name="consultant_id" required>
              <option name="choice" id="choice" value="">Sélectionner un consultant</option>
              <?php foreach ($consultants as $consultant) {
                $cons = substr($consultant->fullname, 0, 4);
                $selected = $row->id == $consultant->id ? 'selected' : ''; ?>
                <?= "<option value='$consultant->id' data-value='$cons' name='consultant_id' id='consultant' $selected>" ?><?= $consultant->fullname ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="input-box">
            <select id="customer" name="customer_id" required>
              <option name="choice" id="choice" value="">Sélectionner un client</option>
              <?php foreach ($customers as $customer) {
                ?>
                <option value="<?= $customer->id ?>" data-value="<?= $customer->name ?>" name="customer" id="customer"><?= $customer->name ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="input-box">
            <select name="job" required>
              <option name="choice" id="choice" value="">Sélectionner un poste</option>
              <?php foreach ($jobs as $job) {
                ?>
                <option value="<?= $job->id ?>" name="job" id="job"><?= $job->name ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="input-box">
            <input type="text" placeholder="Début de la mission" name="start" id="start" value="" class="datepicker" required>
          </div>

          <div class="input-box">
            <input type="text" placeholder="Fin de la mission" name="stop" id="stop" value="" class="datepicker" required>
          </div>

          <div class="form-group">
            <div class="input-box">
              <button type="submit" class="btn btn-info">Valider</button>
              <button class="btn btn-info retour"><a onclick="goBack()">Annuler</a></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<body>
  <div class="container">
    <div class="card mt-4">
      <div class="card-header">
        <h2 class="text-center text-uppercase">Missions</h2>
        <div class="add d-flex">
          <div class="bouton">
            <button type="button" class='btn btn-primary mr-1' data-toggle="modal" data-target="#myModal"><i class="fas fa-plus"></i></button>
            <div id="edit"></div>
            <div id="delete" onclick="return confirm('Etes-vous sûr de vouloir supprimer cette mission ?')"></div>
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
          mission: "<?= $row->mission ?>",
          customer: "<?= utf8_encode($row->customer) ?>",
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

    $(document).ready(function(fourletters) {
      $("#consultant, #customer").change(function() {
        let selectedItem = $(this).val();
        let FourLetters = $('option:selected', consultant).attr('data-value');
        let customerName = $('option:selected', customer).attr('data-value');

        if (FourLetters === undefined) {
          document.getElementById('name').value = '-' + customerName;
        } else if (customerName === undefined) {
          document.getElementById('name').value = FourLetters;
        } else {
          document.getElementById('name').value = FourLetters + '-' + customerName;
        }
      });
    });
  </script>
</body>
<?php require '../layout/footer.php'; ?>

</html>