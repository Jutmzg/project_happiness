<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php';

$sql = "SELECT CONCAT(c.lastname,' ', c.firstname) as fullname, c.mail mail, m.id mission_id, m.name mission, CONCAT(mana.lastname,' ', mana.firstname) manager 
FROM mission m
JOIN consultant c
ON m.consultant_id = c.id
JOIN manager mana
ON c.manager_id = mana.id
WHERE NOT EXISTS (
    SELECT * 
    FROM enquete e
    WHERE e.mission_id = m.id  
)
AND c.state = 0 AND m.state = 0
ORDER BY fullname";
$statement = $connection->prepare($sql);
$statement->execute();
$consultants = $statement->fetchAll(PDO::FETCH_OBJ);
?>
<body>

  <div class="container">
    <div class="card mt-4">
      <div class="card-header">

        <h2 class="text-center text-uppercase">Enquêtes</h2>
        <button class="btn btn-primary add" onclick="getSelectedMissionId()">Créer</button>
        <a href="/Akkappiness/export/exporttest.php" class="btn btn-success add"><i class="fas fa-file-excel"></i></a>
        <div class="card-body">
          <input type="text" class="form-control col-3" id="filter-text-box" placeholder="Rechercher" oninput="onFilterTextBoxChanged()" />
          <div id="myGrid" class="ag-theme-balham"></div>
        </div>
      </div>
    </div>
  </div>
  <div id="missionId"></div>
<script type="text/javascript" charset="utf-8">
  // specify the columns
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
      width: 190,

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
  // specify the data
  let rowData = [
    <?php foreach ($consultants as $consultant) { ?> {
        nom: "<?= utf8_encode($consultant->fullname) ?>",
        mail: "<?= $consultant->mail ?>",
        mission: "<?= $consultant->mission_id ?>",
        missionName: "<?= $consultant->mission ?>",
        manager: "<?= utf8_encode($consultant->manager) ?>"

      },
    <?php } ?>
  ];
  // let the grid know which columns and what data to use
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
      let missions = element.mission
      $.ajax({
        url: "insertion.php",
        type: "post",
        
        data: {
          done: 1,
          info: missions
        },
        success: function(data) {
          iziToast.success({position: "center", message: 'Enquête effectuée'});

        }
      });
    });
  }

  function onFilterTextBoxChanged() {
    gridOptions.api.setQuickFilter(document.getElementById('filter-text-box').value);
  }

  iziToast.settings({
      timeout: 3000, // default timeout
      resetOnHover: true,
      // icon: '', // icon class
      transitionIn: 'flipInX',
      transitionOut: 'flipOutX',
      position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
      onOpen: function () {
        console.log('callback abriu!');
      },
      onClose: function () {
        console.log("callback fechou!");
      }
    });

    // info
    $('#infoClick').click(function () {
      iziToast.success({position: "center", message: 'Enquête effectuée'});
    }); // ! click

    // custom toast
    $('#customClick').click(function () {

      iziToast.show({
        color: 'dark',
        icon: 'fa fa-user',
        title: 'Hey',
        message: 'Custom Toast!',
        position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
        progressBarColor: 'rgb(0, 255, 184)',
        buttons: [
          [
            '<button>Close</button>',
            function (instance, toast) {
              instance.hide({
                transitionOut: 'fadeOutUp'
              }, toast);
            }
          ]
        ]
      });

    }); 
</script>
</body>
<?php require '../layout/footer.php'; ?>
</html>
