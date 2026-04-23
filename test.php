<!-- This is meant to try out the pagination feature, currently a work in progress --> 

<?php 
include_once "includes/db.php";
$observations = getAllObservations();
// var_dump($observations);

$js_array = json_encode($observations);
// echo "var javascript_array = ". $js_array . ";\n";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Pagination with JavaScript</title>
    <style>
        table {
            margin: auto;
        }

        #pagination {
            text-align: center;
        }
        
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
        }
    </style>
</head>

<body>

<label for="dateFilterStart">Select Start Date: </label>
<input type="date" id="dateFilterStart">

<label for="dateFilterEnd">Select End Date: </label>
<input type="date" id="dateFilterEnd">

<button onclick="filterTable()">Search</button>

    <table id="myTable">
        <tr>
            <th>locality</th>
            <th>individual_count</th>
            <th>latitude</th>
            <th>longitude</th>
            <th>observation_date</th>
            <th>CRUD</th>
        </tr>
        <!-- Table rows will be added dynamically -->
    </table>
    <div id="pagination"></div>

<script>
    
    var tempArray = <?php echo json_encode($observations); ?>;



    const rowsPerPage = 50;
    let currentPage = 1;

    function displayTable(page) {
        const table = document.getElementById("myTable");
        const startIndex = (page - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        const slicedData = tempArray.slice(startIndex, endIndex);

            // Clear existing table rows
            table.innerHTML = `
        <tr>
            <th>locality</th>
            <th>individual_count</th>
            <th>latitude</th>
            <th>longitude</th>
            <th>observation_date</th>
            <th>CRUD</th>
        </tr>
    `;

            // Add new rows to the table
            slicedData.forEach(tempArray => {
                const row = table.insertRow();
                const localityCell = row.insertCell(0);
                const countCell = row.insertCell(1);
                const latitudeCell = row.insertCell(2);
                const longitudeCell = row.insertCell(3);
                const observation_dateCell = row.insertCell(4);
                const CRUD_Cell = row.insertCell(5);

                localityCell.innerHTML = tempArray.locality;
                countCell.innerHTML = tempArray.individual_count;
                latitudeCell.innerHTML = tempArray.latitude;
                longitudeCell.innerHTML = tempArray.longitude;
                observation_dateCell.innerHTML = tempArray.observation_date;
                key = tempArray.id;
                CRUD_Cell.innerHTML = "<td><a href='add_observation.php?id=" + key + "'>Edit</a></td>";
            });

            // Update pagination
            updatePagination(page);
        }

        function updatePagination(currentPage) {
            const pageCount = Math.ceil(tempArray.length / rowsPerPage);
            const paginationContainer = document.getElementById("pagination");
            paginationContainer.innerHTML = "";

            for (let i = 1; i <= pageCount; i++) {
                const pageLink = document.createElement("a");
                pageLink.href = "#";
                pageLink.innerText = i;
                pageLink.onclick = function () {
                    displayTable(i);
                };
                if (i === currentPage) {
                    pageLink.style.fontWeight = "bold";
                }
                paginationContainer.appendChild(pageLink);
                paginationContainer.appendChild(document.createTextNode(" "));
            }
        }

        // Initial display
        displayTable(currentPage);
    </script>
</body>

</html>


---$_COOKIE



<?php if (empty($species)): ?>
    <p>No observations found in the database.</p>
<?php else: ?>
    <table id="results">
        <thead>
            <tr>
                <th>locality</th>
                <th>individual_count</th>
                <th>latitude</th>
                <th>longitude</th>
                <th>observation_date</th>
                <th>CRUD</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php foreach ($observationArray as $item): ?>
                <?php if ($item[5] = $pageTitle): ?>
                    <tr>
                        <!-- Locality [0], String -->
                        <?php if(strlen($item[0]) > 0): ?>
                            <td><?php echo e($item[0]); ?></td>
                        <?php else: ?>
                            <td><?php echo "Locality Not Registered"; ?></td>
                        <?php endif ?>
                        <!-- Count [1], Int -->
                        <?php if(!is_null($item[1])): ?>
                            <td><?php echo e($item[1]); ?></td>
                        <?php else: ?>
                            <td><?php echo "Count not registered"; ?></td>
                        <?php endif ?>
                        <!-- Latitude [2], Float -->
                        <?php if(!is_null($item[2])): ?>
                            <td><?php echo e($item[2]); ?></td>
                        <?php else: ?>
                            <td><?php echo "N/A"; ?></td>
                        <?php endif ?>
                        <!-- Longitude [3], Float -->
                        <?php if(!is_null($item[3])): ?>
                            <td><?php echo e($item[3]); ?></td>
                        <?php else: ?>
                            <td><?php echo "N/A"; ?></td>
                        <?php endif ?>
                        <!-- Observation Date [4] -->
                        <?php if(strlen($item[4]) > 0): ?>
                            <td><?php echo e($item[4]); ?></td>
                        <?php else: ?>
                            <td><?php echo "Observation Date Not Registered"; ?></td>
                        <?php endif ?>
                        <!-- Edit Option -->
                        <td><a href="add_observation.php?id=<?= $item[6] ?>">Edit</a></td>
                    </tr>
                <?php endif ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    
<?php endif; ?>