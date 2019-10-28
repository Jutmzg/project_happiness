<!DOCTYPE html>
  <html lang="fr">

  <?php require '../layout/header.php'; 
  
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
    <div class="container">
      <div class="card mt-4">
        <div class="card-header">
          <h2 class="text-center text-uppercase">Consultants</h2>
          <div class="add d-flex">
          <div class="bouton">
              <a href="/Akkappiness/consultant/create.php" class='btn btn-primary mr-1'><i class="fas fa-plus"></i></a>
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
      // specify the data
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
          "<a href=delete.php?id=" + action + " class='btn btn-danger'><i class='fas fa-trash-alt'></i></a>";
      }
      function edit(){
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