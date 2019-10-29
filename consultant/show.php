<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php';
$message = '';

// RECUPERE LES MANAGERS 
$sql = "SELECT id, mail, CONCAT(lastname,' ', firstname) as fullname FROM manager WHERE state = 0 ORDER BY fullname";
$statement = $connection->query($sql);
$statement->execute();
$managers = $statement->fetchAll(PDO::FETCH_OBJ);

// RECUPERE LES POSTES 

$sql2 = 'SELECT * FROM job ORDER BY name';
$statement = $connection->query($sql2);
$statement->execute();
$jobs = $statement->fetchAll(PDO::FETCH_OBJ);

// RECUPERE LES CLIENTS 

$sql = 'SELECT * FROM customer WHERE state = 0 ORDER BY name';
$statement = $connection->query($sql);
$statement->execute();
$customers = $statement->fetchAll(PDO::FETCH_OBJ);

// INSERTION 
if (
  isset($_POST['lastname']) &&
  isset($_POST['firstname']) &&
  isset($_POST['mail']) &&
  isset($_POST['manager_id'])
) {

  $lastname = $_POST['lastname'];
  $firstname = $_POST['firstname'];
  $mail = $_POST['mail'];
  $manager_id = $_POST['manager_id'];
  $state = 0;


  $sql = 'INSERT INTO consultant(lastname, firstname, mail, state, manager_id) VALUES(:lastname, :firstname, :mail, :state, :manager_id)';
  $statement = $connection->prepare($sql);
  if ($statement->execute([':lastname' => $lastname, ':firstname' => $firstname, ':mail' => $mail, ':state' => $state, ':manager_id' => $manager_id])) {
    $message = ' Consultant ajouté';
    $id = $connection->lastInsertId();
  }
}

if (
  isset($_POST['name']) &&
  isset($_POST['customer_id']) &&
  isset($_POST['job']) &&
  isset($_POST['start']) &&
  isset($_POST['stop'])
) {

  $name = $_POST['name'];
  $customer_id = $_POST['customer_id'];
  $job_id = $_POST['job'];
  $consultant_id = $id;
  $start = date('Y-m-d', strtotime($_POST['start']));
  $stop = date('Y-m-d', strtotime($_POST['stop']));
  $state = 0;

  $sql = 'INSERT INTO mission(name, customer_id, job_id, consultant_id, start, stop,state) VALUES(:name, :customer_id, :job_id, :consultant_id, :start, :stop, :state)';
  $statement = $connection->prepare($sql);
  if ($statement->execute([':name' => $name, ':customer_id' => $customer_id, ':job_id' => $job_id, ':consultant_id' => $consultant_id, ':start' => $start, ':stop' => $stop, ':state' => $state])) {
    $message .= "<div class='alert alert-success'><i class='far fa-check-circle'></i> Mission enregistrée</div>";
  }
}

// SUPPRESSION 
if (
  isset($_GET['id'])
) {
  $ids = explode(',', $_GET['id']);

  foreach ($ids as $id) {
    $sql = 'UPDATE consultant SET state = 1 WHERE id=:id';
    $statement = $connection->prepare($sql);
    if ($statement->execute([':id' => $id])) {
      header("Location: show.php");
    }
  }
}

if ($message !== '') {
  echo "<div class='alert alert-success'><i class='far fa-check-circle'></i>$message</div>";
}

$sql = "SELECT c.id, CONCAT(c.lastname,' ', c.firstname) as fullname, 
c.mail, CONCAT(mana.lastname,' ',mana.firstname) manager 
FROM consultant c
JOIN manager mana 
ON c.manager_id = mana.id
WHERE c.state = 0
ORDER BY fullname ASC";
$statement = $connection->prepare($sql);
$statement->execute();
$consultants = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<body>
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="popUpMission">
        <a href="/Akkappiness/consultant/show.php" class="close" type="button"><i class="fas fa-times" id="cross"></i></a>
        <h4 class="modal-title text-center">CREATION D'UN POSTE</h4>
        <div class="modal-content">
          <form method="post">
            <div class="input-box">
              <input type="text" name="lastname" id="lastname" class="" maxlength="50" minlength="2" placeholder="Nom" required>
            </div>

            <div class="input-box">
              <input type="text" name="firstname" id="firstname" class="" maxlength="50" minlength="2" placeholder="Prénom" required>
            </div>

            <div class="input-box">
              <input type="email" name="mail" id="mail" class="" maxlength="50" minlength="5" placeholder="Email" required>
            </div>

            <div class="input-box">
              <select name="manager_id" required>
                <option name="choice" id="choice" value="">Sélectionner un manager</option>
                <?php foreach ($managers as $manager) {
                  ?>
                  <option value="<?= $manager->id ?>" name="manager" id="manager"><?= utf8_encode($manager->fullname) ?></option>
                <?php } ?>
              </select>
            </div>

            <!-- MISSION -->
            <div id="slide">Créer une mission <i class="fas fa-sort-down fa-x"></i></div>
            <div id="panel">
              <div class="input-box">
                <input value="" type="text" placeholder="Nom" name="name" id="name" maxlength="50" minlength="2" readonly>
              </div>
              <div class="input-box">
                <select id="customer" name="customer_id" value="0">
                  <option name="choice" id="choice" value="">Sélectionner un client</option>
                  <?php foreach ($customers as $customer) {
                    ?>
                    <option value="<?= $customer->id ?>" data-value="<?= $customer->name ?>" name="customer" id="customer"><?= $customer->name ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="input-box">
                <select name="job" id="job">
                  <option name="choice" id="choice" value="">Sélectionner un poste</option>
                  <?php foreach ($jobs as $job) {
                    ?>
                    <option value="<?= $job->id ?>" name="job" id="job"><?= $job->name ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="input-box">
                <input type="text" placeholder="Début de la mission" name="start" id="start" value="" class="datepicker">
              </div>

              <div class="input-box">
                <input type="text" placeholder="Fin de la mission" name="stop" id="stop" value="" class="datepicker">
              </div>

            </div>
            <div class="form-group">
              <div class="input-box">
                <div class="ValAnn">
                  <button type="submit" class="btn btn-info">Valider</button>
                  <a href="/Akkappiness/consultant/show.php" class="btn btn-info">Annuler</a>
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
        <h2 class="text-center text-uppercase">Consultants</h2>
        <div class="add d-flex">
          <div class="bouton">
            <button type="button" class='btn btn-primary mr-1' data-toggle="modal" data-target="#myModal"><i class="fas fa-plus"></i></button>
            <div id="edit"></div>
            <div id="delete" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce consultant ?')"></div>
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
    let columnDefs = [{
        headerName: "Nom",
        field: "nom",
        sortable: true,
        filter: true,
        width: 300,
        suppressSizeToFit: true,

      },
      {
        headerName: "Email",
        field: "mail",
        sortable: true,
        filter: true,
        width: 300,
      },
      {
        headerName: "Manager",
        field: "manager",
        sortable: true,
        filter: true,
        width: 300,

      },
      {
        headerName: "Action",
        field: "action",
        hide: true,

      },
    ];
    let rowData = [
      <?php foreach ($consultants as $consultant) { ?> {
          nom: "<?= $consultant->fullname ?>",
          mail: "<?= $consultant->mail ?>",
          manager: "<?= utf8_encode($consultant->manager) ?>",
          action: "<?= $consultant->id ?>",

        },
      <?php } ?>

    ];
    let gridOptions = {
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

    let eGridDiv = document.querySelector('#myGrid');
    new agGrid.Grid(eGridDiv, gridOptions);

    function onFilterTextBoxChanged() {
      gridOptions.api.setQuickFilter(document.getElementById('filter-text-box').value);
    }

    function buttons() {
      let selectedNodes = gridOptions.api.getSelectedNodes()
      let selectedData = selectedNodes.map(function(node) {
        return node.data
      })
      let action = selectedData.map(function(node) {
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
    // SHOW MISSION
    $("#slide").click(function() {
      $("#panel").slideToggle("slow");
      $("i", this).toggleClass("fas fa-sort-down fa-x fas fa-sort-up fa-x");
      console.log($("i", this).toggleClass("fas fa-sort-down fa-x fas fa-sort-up fa-x"));
    });

    $(document).ready(function(fourletters) {
      $("#lastname, #customer").change(function() {
        let selectedItem = $(this).val();
        let FourLetters = document.getElementById('lastname').value.substr(0, 4);
        let customerName = $('option:selected', customer).attr('data-value');

        if (FourLetters === undefined) {
          document.getElementById('name').value = '-' + customerName;
        } else if (customerName === undefined) {
          document.getElementById('name').value = FourLetters.toUpperCase();
        } else {
          document.getElementById('name').value = FourLetters.toUpperCase() + '-' + customerName;
        }
      });
    });


    $('select[name=customer_id]').change(function() {
      if ($(this).val() != null) {
        $('#job').prop('required', true);
        $('#start').prop('required', true);
        $('#stop').prop('required', true);
        if ($(this).val() == '') {
          $('#job').prop('required', false);
          $('#start').prop('required', false);
          $('#stop').prop('required', false);
        }
      }
    });
    $('select[name=job]').change(function() {
      if ($(this).val() != null) {
        $('#customer').prop('required', true);
        $('#start').prop('required', true);
        $('#stop').prop('required', true);
        if ($(this).val() == '') {
          $('#customer').prop('required', false);
          $('#start').prop('required', false);
          $('#stop').prop('required', false);

        }
      }
    });
    $('input[name=start]').change(function() {
      if ($(this).val() != null) {
        $('#customer').prop('required', true);
        $('#job').prop('required', true);
        $('#stop').prop('required', true);
        if ($(this).val() == '') {
          $('#customer').prop('required', false);
          $('#job').prop('required', false);
          $('#stop').prop('required', false);

        }
      }
    });
    $('input[name=stop]').change(function() {
      if ($(this).val() != null) {
        $('#customer').prop('required', true);
        $('#job').prop('required', true);
        $('#start').prop('required', true);
        if ($(this).val() == '') {
          $('#customer').prop('required', false);
          $('#job').prop('required', false);
          $('#start').prop('required', false);

        }
      }
    });
  </script>
</body>
<?php require '../layout/footer.php'; ?>

</html>