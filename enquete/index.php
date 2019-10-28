<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php';

$sql = "SELECT CONCAT(c.lastname,' ', c.firstname) as fullname, c.mail mail, m.id mission_id, m.name mission, CONCAT(mana.lastname,' ' , mana.firstname) manager
        FROM mission m
        JOIN consultant c
        ON m.consultant_id = c.id
        JOIN manager mana
        ON c.manager_id =  mana.id
        WHERE c.state = 0 AND m.state = 0
        AND NOT
        EXISTS (
                SELECT *
                FROM enquete e
                WHERE e.mission_id = m.id
                AND CONCAT(YEAR(e.created_at),MONTH(e.created_at)) = CONCAT(YEAR(CURRENT_DATE()),MONTH(CURRENT_DATE()))
                )
        ORDER BY fullname";

$statement = $connection->prepare($sql);
$statement->execute();
$consultants = $statement->fetchAll(PDO::FETCH_OBJ);
?>
<body>

  <div class="container">
    <div class="card mt-4">
      <div class="card-header">

        <h2 class="text-center text-uppercase darkblue">Enquêtes</h2>
        <button class="btn btn-info add" onclick="getSelectedMissionId()">Créer</button>
        <a href="/Akkappiness/export/export.php" class="btn btn-success add"><i class="fas fa-file-excel"></i></a>
        <div class="card-body">
          <input type="text" class="form-control col-3" id="filter-text-box" placeholder="Rechercher" oninput="onFilterTextBoxChanged()" />
          <div id="myGrid" class="ag-theme-balham"></div>
        </div>
      </div>
    </div>
  </div>
  <div id="missionId"></div>

<?php
  if (isset($_POST['done'])) {
    $mission_id = $_POST['info'];
    $now = date("Y-m-d H:i:s");

       $sql = 'INSERT INTO enquete(mission_id,created_at) VALUES(:mission_id,:created_at)';
        $statement = $connection->prepare($sql);
        $statement->execute(array(':mission_id' => $mission_id,':created_at' => $now));  
        return true;
}
?>
<script type="text/javascript">
  let columnDefs = [{
      headerName: "",
      field: "nom",
      sortable: true,
      filter: true,
      width: 40,
      suppressSizeToFit: true,
      checkboxSelection: true,
      headerCheckboxSelection: true,
      headerCheckboxSelectionFilteredOnly: true,

    },
    {
      headerName: "Nom",
      field: "nom",
      sortable: true,
      filter: true,
      width: 220,
      suppressSizeToFit: true,

    },
    {
      headerName: "Email",
      field: "mail",
      sortable: true,
      filter: true,
      width: 220,
    },
    {
      headerName: "Mission ID",
      field: "mission",
      sortable: true,
      filter: true,
      width: 220,
      hide: true,
    },
    {
      headerName: "Mission",
      field: "missionName",
      sortable: true,
      filter: true,
      width: 207,

    },
    {
      headerName: "Manager",
      field: "manager",
      sortable: true,
      filter: true,
      width: 220,

    },
    {
      headerName: "Action",
      field: 'action',
      hide: true,
      width: 250,

    },
  ];
  let rowData = [
    <?php foreach ($consultants as $consultant) { ?> {
        nom: "<?= $consultant->fullname ?>",
        mail: "<?= $consultant->mail ?>",
        mission: "<?= $consultant->mission_id ?>",
        missionName: "<?= $consultant->mission ?>",
        manager: "<?= utf8_encode($consultant->manager) ?>"

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
    rowMultiSelectWithClick: true,
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

  function getSelectedMissionId() {
    let success =  iziToast.success({position: "center", message: 'Enquête(s) effectuée(s)'});
    let selectedNodes = gridOptions.api.getSelectedNodes()
    let selectedData = selectedNodes.map(function(node) {
      return node.data
    })
    let mission = selectedData.map(function(node) {
      return node.mission
    }).join(',')
    document.getElementById("missionId").innerHTML = mission;
    
    selectedData.forEach(function(element) {
      let missions = element.mission
      $.ajax({
        url: "index.php",
        type: "post",
        
        data: {
          done: 1,
          info: missions
        },
      });
    });
    return success
  }

  function onFilterTextBoxChanged() {
    gridOptions.api.setQuickFilter(document.getElementById('filter-text-box').value);
  }

  iziToast.settings({
      timeout: 2000, 
      resetOnHover: true,
      transitionIn: 'flipInX',
      transitionOut: 'flipOutX',
      position: 'topRight',
    });
   
</script>
</body>
<?php require '../layout/footer.php'; ?>
</html>
