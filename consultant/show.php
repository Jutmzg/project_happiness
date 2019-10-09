<?php
require '../db/db.php';

$sql = "SELECT c.id, CONCAT(c.firstname,' ', c.lastname) as fullname, 
c.mail, CONCAT(mana.firstname,' ',mana.lastname) manager, m.name mission 
FROM consultant c
JOIN manager mana 
ON c.manager_id = mana.id
LEFT JOIN mission m
ON c.mission_id = m.id
WHERE c.state = 0";
$statement = $connection->prepare($sql);
$statement->execute();
$consultants = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<?php require '../layout/header.php'; ?>

<div class="container">
  <div class="card mt-5">
    <div class="card-header">


    

      <h2>Consultants</h2>
      <a href="/Akkappiness/consultant/create.php"><button type="button" class="btn btn-primary"><i class="fas fa-user-plus"></i></button></a>
      <div id="editAndDelete"></div>
      <div class="card-body">

        <input type="text" class="form-control col-3" id="filter-text-box" placeholder="Rechercher" oninput="onFilterTextBoxChanged()" />

        <div id="myGrid" style="height: 600px;width:100%;" class="ag-theme-balham" onclick="buttons()"></div>
        
        
      </div>
    </div>
  </div>
</div>

<?Php foreach($consultants as $consultant){
  $test[] = '<a href=edit.php?id='.$consultant->id. ' class="btn btn-info"><i class="fas fa-user-edit fa-xs"></i></a>' ;
}
?>

</head>
<body>

<script type="text/javascript" charset="utf-8">
  // specify the columns 

  var variableRecuperee = <?php echo json_encode($test); ?>;
  console.log(variableRecuperee)
  var PRODUCTS_ACTIONS_TEMPLATE = 
    `
<a href="edit.php?id=" class="btn btn-info"><i class="fas fa-user-edit fa-xs"></i></a>
                <a onclick="return confirm('Etes vous sur de vouloir effectuer la suppression?')" href="delete.php?id=1" class='btn btn-danger'><i class="fas fa-trash-alt"></i></a>`;


  var columnDefs = [{
      headerName: "Nom",
      field: "nom",
      sortable: true,
      filter: true,

    },
    {
      headerName: "Email",
      field: "mail",
      sortable: true,
      filter: true,
    },
    {
      headerName: "Mission",
      field: "mission",
      sortable: true,
      filter: true,
    },
    {
      headerName: "Manager",
      field: "manager",
      sortable: true,
      filter: true,
    },
    {
      headerName: "Action",
      field: 'action',
      hide:true,
     // template: PRODUCTS_ACTIONS_TEMPLATE,
      
    },
    
  ];
  // specify the data
  var rowData = [
    <?php foreach ($consultants as $consultant) { ?>
      
      {
      
        nom: "<?= $consultant->fullname ?>",
        mail: "<?= $consultant->mail ?>",
        mission: "<?= $consultant->mission ?>",
        manager: "<?= $consultant->manager ?>", 
        action:   "<?= $consultant->id ?>",
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
    rowData: rowData,
    rowSelection: 'multiple',
    headerHeight: 50,
    floatingFiltersHeight: 50,
    pivotGroupHeaderHeight: 50,
    piotGroupHeaderHeight: 50,
    // hauteur des rows
    getRowHeight: function(params) {
      return 80;
    },
  };

 
  var eGridDiv = document.querySelector('#myGrid');

  new agGrid.Grid(eGridDiv, gridOptions);

  function getSelectedRows() {
    var selectedNodes = gridOptions.api.getSelectedNodes()
    var selectedData = selectedNodes.map(function(node) {
      return node.data
    })
    var mail = selectedData.map(function(node) {
      return node.mail
    }).join('<br>')
    document.getElementById("mailing").innerHTML = mail;

  }

  function onFilterTextBoxChanged() {
    gridOptions.api.setQuickFilter(document.getElementById('filter-text-box').value);
  }


  function buttons() {
    var selectedNodes = gridOptions.api.getSelectedNodes()
    var selectedData = selectedNodes.map(function(node) {
      return node.data
    })
    var action = selectedData.map(function(node){
      return node.action
    })
  document.getElementById("editAndDelete").innerHTML = 
  "<a href=edit.php?id=" + action + " class='btn btn-info'><i class='fas fa-user-edit fa-xs'></i></a> <a 'onclick=return confirm('Etes vous sur de vouloir effectuer la suppression?)' href=delete.php?id=" + action + " class='btn btn-danger'><i class='fas fa-trash-alt'></i></a>";
  

}




</script>
<?php require '../layout/footer.php'; ?>