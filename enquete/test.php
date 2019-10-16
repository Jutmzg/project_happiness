<!DOCTYPE html>
<html lang="en">
<?php require '../layout/header.php';

require '../db/db.php';
$sql = "SELECT c.firstname fullname, c.mail mail, m.id mission_id, m.name mission, mana.firstname manager FROM mission m
JOIN consultant c
ON m.id = c.mission_id
JOIN manager mana
ON c.manager_id = mana.id
WHERE c.state = 0";
$statement = $connection->prepare($sql);
$statement->execute();
$consultants = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<body>
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
            <h2 class="text-center text-uppercase">Enquête</h2>
            <button class="btn btn-primary" onclick="getSelectedMissionId()">Envoyer</button>

                    <div class="card-body">
                        <input type="text" class="form-control col-3" id="filter-text-box" placeholder="Rechercher" oninput="onFilterTextBoxChanged()" />
                        <div id="myGrid" class="ag-theme-balham"></div>
                    </div>
                    <div id="missionId"></div>               
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" charset="utf-8">
    // specify the columns
    var columnDefs = [{
            headerName: "",
            field: "nom",
            sortable: true,
            filter: true,
            width: 40,
            suppressSizeToFit: true,
            checkboxSelection: true,

        },
        {
            headerName: "Nom",
            field: "nom",
            sortable: true,
            filter: true,
            width: 250,
            suppressSizeToFit: true,

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
            hide: true,
        },
        {
            headerName: "Mission",
            field: "missionName",
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
                missionName: "<?= $consultant->mission ?>",
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
            $.ajax({
                url: "insertion.php",
                type: "post",
                async: false,
                data: {
                    done: 1,
                    info: missions
                },
                success: function(data) {

                }

            });
        });
    }

    function onFilterTextBoxChanged() {
        gridOptions.api.setQuickFilter(document.getElementById('filter-text-box').value);
    }
</script>

<style>
    #display {

        width: 100px;
        height: 100px;
    }

    h2 {
        background-color: #dededea1;
        width: 243px;
    }
</style>

<?php require '../layout/footer.php'; ?>