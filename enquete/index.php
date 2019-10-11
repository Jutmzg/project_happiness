<!DOCTYPE html>
<html lang="en">
<?php require '../layout/header.php';

require '../db/db.php';
$sql = "SELECT c.id, CONCAT(c.firstname,' ', c.lastname) as fullname, 
c.mail, CONCAT(mana.firstname,' ',mana.lastname) manager, c.mission_id 
FROM consultant c
JOIN manager mana 
ON c.manager_id = mana.id
WHERE c.state = 0";
$statement = $connection->prepare($sql);
$statement->execute();
$consultants = $statement->fetchAll(PDO::FETCH_OBJ);

?>
<a class="btn btn-primary" href="insertion.php">CREER LES ENQUETES</a>
<form method="POST">
  <input id="name" type="text">
  <input value="POST" id="save" type="submit">
</form>

<div id="display">
</div>

<button class="btn btn-primary" onclick="getSelectedMissionId()">MissionID</button>

<div class="container d-flex">
  <div id="myGrid" style="height: 400px;width:600px;" class="ag-theme-balham"></div>
  <div class="form-mail m-4">

    <div class="m-1" id="missionId"></div>
    <form method="post">
      <button type="submit" name="submitbutton" class="btn btn-info" value="button">Valider</button>
    </form>
  </div>
</div>
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {

    $("#save").click(function() {
      
      var name = $("#name").val();
      $.ajax({
        url: "insertion.php",
        type: "post",
        async: false,
        data: {
          done: 1,
          "name": name,
        },
        success: function(data){
          displayFromDatabase();
          $("#name").val('');


        }

      });
    });
  });

  function displayFromDatabase(){
    $.ajax({
      url: "insertion.php",
      type: "POST",
      async: false,
      data:{
        "display": 1
      },
      success: function(data){
        $("#display").html(data);

      }
    })
  }

  // specify the columns
  var columnDefs = [{
      headerName: "Nom",
      field: "nom",
      sortable: true,
      filter: true,
      width: 250,
      suppressSizeToFit: true,
      checkboxSelection: true,

    },
    {
      headerName: "Email",
      field: "mail",
      sortable: true,
      filter: true,
      width: 250,
    },
    {
      headerName: "Mission ID",
      field: "mission",
      sortable: true,
      filter: true,
      width: 250,
    },
    {
      headerName: "Manager",
      field: "manager",
      sortable: true,
      filter: true,
      width: 250,

    },
    {
      headerName: "Action",
      field: 'action',
      hide: true,
      width: 250,

    },

  ];

  // specify the data
  let rowData = [
    <?php foreach ($consultants as $consultant) { ?> {
        nom: "<?= utf8_encode($consultant->fullname) ?>",
        mail: "<?= $consultant->mail ?>",
        mission: "<?= $consultant->mission_id ?>",
        manager: "<?= utf8_encode($consultant->manager) ?>"
      },
    <?php } ?>
  ];

  // let the grid know which columns and what data to use
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

  // lookup the container we want the Grid to use
  let eGridDiv = document.querySelector('#myGrid');

  // create the grid passing in the div to use together with the columns & data we want to use
  new agGrid.Grid(eGridDiv, gridOptions);

  function getSelectedMissionId() {
    let selectedNodes = gridOptions.api.getSelectedNodes()
    let selectedData = selectedNodes.map(function(node) {
      return node.data
    })
    let mission = selectedData.map(function(node) {
      return node.mission

    }).join(',')
    document.getElementById("missionId").innerHTML = mission;

    selectedData.forEach(function(element) {

      // on récupère l'élement mission
      var missions = element.mission
      console.log(missions);
    });

  }

  function onFilterTextBoxChanged() {
    gridOptions.api.setQuickFilter(document.getElementById('filter-text-box').value);
  }
</script>

<style>
  #mailing {
    background: #c3bfbf;
    width: 243px;
    height: 300px;
  }

  #display {
    
    width: 243px;
    height: 300px;
  }

  h2 {
    background-color: #dededea1;
    width: 243px;
  }

  .container {
    align-items: baseline;
  }


  #missionId {
    background: red;
    width: 243px;
    height: 300px;
  }
</style>

<?php require '../layout/footer.php'; ?>