<html>
<?php require './layout/header.php'; ?>

<head>
  <script src="https://unpkg.com/ag-grid-enterprise/dist/ag-grid-enterprise.min.noStyle.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/ag-grid-community/dist/styles/ag-grid.css">
  <link rel="stylesheet" href="https://unpkg.com/ag-grid-community/dist/styles/ag-theme-balham.css">
</head>

<!-- <div class="col-md-10 col-md-offset-1 spacer-below-20">
    <label>The date</label>
    <div class="input-group">
        <input class="datepicker" type="text" name="date">
    </div>
</div> -->
<?php

require 'db/db.php';
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
<input type="text" id="filter-text-box" placeholder="Filter..." oninput="onFilterTextBoxChanged()" />
<button class="btn btn-primary" onclick="getSelectedRows()">-></button>
<div class="container d-flex">

  <div id="myGrid" style="height: 400px;width:600px;" class="ag-theme-balham"></div>


  <div class="form-mail m-4">
    <label>FROM</label>
    <input class="form-control mb-3" type="text" value="mailduconnecté@gmail.com" />
    <textarea class="form-control" type="textarea">Bonjour à tous .....</textarea>
    <label for="exampleFormControlSelect2">Example multiple select</label>
    <select multiple class="form-control" id="">
      <option selected id="">1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
    <p class="text-center">DESTINATAIRE</p>
    <div class="m-1" id="mailing"></div>
    <input class="btn btn-primary d-flex m-auto" type="submit" value="Envoyer"/>

  </div>
</div>
<script type="text/javascript" charset="utf-8">
  // specify the columns

  var columnDefs = [{
      headerName: "NOM",
      field: "nom",
      sortable: true,
      filter: true,

      checkboxSelection: true
    },
    {
      headerName: "EMAIL",
      field: "mail",
      sortable: true,
      filter: true
    },
    {
      headerName: "MANAGER",
      field: "manager",
      sortable: true,
      filter: true
    },

  ];

  // specify the data

  var rowData = [
    <?php foreach ($consultants as $consultant) { ?>

      {
        nom: "<?= $consultant->fullname ?>",
        mail: "<?= $consultant->mail ?>",
        manager: "<?= $consultant->manager ?>"
      },
    <?php } ?>

  ];

  // let the grid know which columns and what data to use
  var gridOptions = {
    columnDefs: columnDefs,
    pagination: true,
    rowData: rowData,
    rowSelection: 'multiple'

  };

  // lookup the container we want the Grid to use
  var eGridDiv = document.querySelector('#myGrid');

  // create the grid passing in the div to use together with the columns & data we want to use
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

</script>

<style>
  #mailing {
    background: #c3bfbf;
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
</style>

<?php require './layout/footer.php'; ?>