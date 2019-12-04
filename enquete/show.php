<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php';

$sql = "SELECT e.id, CONCAT(c.lastname,' ', c.firstname) fullname, c.mail mail, m.name mission, CONCAT(mana.lastname,' ', mana.firstname) manager FROM enquete e 
JOIN mission m 
ON m.id = e.mission_id
JOIN consultant c 
ON c.id = m.consultant_id
JOIN manager mana 
ON mana.id = c.manager_id
WHERE e.state = 1
ORDER BY fullname";
$statement = $connection->prepare($sql);
$statement->execute();
$enquetes = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<body>
  <div class="container">
    <div class="card mt-4">
      <div class="card-header">
        <h2 class="text-center text-uppercase">Enquêtes à envoyer</h2>
        <div class="add d-flex">
          <a class="btn btn-info mr-1" href="/mailing/phpmailer.php">Envoyer</a>
          <div id="DeleteEnquete" onclick="return confirm('Etes vous sur de vouloir effectuer la suppression?')"></div>
        </div>

        <div class="card-body">
          <div class="add d-flex">
          </div>
          <input type="text" class="form-control col-3" id="filter-text-box" placeholder="Rechercher" oninput="onFilterTextBoxChanged()" />
          <div id="myGrid" class="ag-theme-balham" onclick="buttons()"></div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    var columnDefs = [
      {
        headerName: "Nom",
        field: "nom",
        sortable: true,
        filter: true,
        width: 225,
        suppressSizeToFit: true,
      },
      {
        headerName: "Email",
        field: "mail",
        sortable: true,
        filter: true,
        width: 225,
        suppressSizeToFit: true,
      },
      {
        headerName: "Mission",
        field: "mission",
        sortable: true,
        filter: true,
        width: 225,
        suppressSizeToFit: true,
      },
      {
        headerName: "Manager",
        field: "manager",
        sortable: true,
        filter: true,
        width: 225,
        suppressSizeToFit: true,
      },
      {
        headerName: "Action",
        field: 'action',
        hide: true,
      },
    ];

    var rowData = [
      <?php foreach ($enquetes as $enquete) { ?> {
          nom: "<?= $enquete->fullname?>",
          mail: "<?= $enquete->mail ?>",
          mission: "<?= $enquete->mission ?>",
          manager: "<?= utf8_encode($enquete->manager) ?>",
          action: "<?= $enquete->id ?>",
        },

      <?php } ?>

    ];
    var gridOptions = {

      columnDefs: columnDefs,
      pagination: true,
      paginationPageSize: 20,
      rowData: rowData,
      rowSelection: 'multiple',
      rowMultiSelectWithClick: true,
      headerHeight: 50,

      // hauteur des rows
      getRowHeight: function(params) {
        return 60;
      },
      localeText: {

        noRowsToShow: 'Aucune ligne',
      }

    };

    var eGridDiv = document.querySelector('#myGrid');
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
      document.getElementById("DeleteEnquete").innerHTML =
        "<a href=delete.php?id=" + action + " class='btn btn-danger'><i class='fas fa-trash-alt'></i></a>";
    }
    
  </script>

</body>
<?php require '../layout/footer.php'; ?>

</html>