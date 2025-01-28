cat inventory.php
<?php
// inventory.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// database connection script
include 'db_connection.php';

// SQL query to fetch all shoes with their associated Brand and Model
$sql = "SELECT
            b.name AS Brand,
            m.name AS Model,
            m.height AS Height,
            s.edition AS Edition,
            s.shoe_condition AS `Condition`,
            s.color AS Color,
            s.size AS Size,
            s.box AS Box,
            s.release_year AS ReleaseYear,
            s.comments AS Comments,
            s.link_stockx AS StockXLink,
            s.link_goat AS GoatLink
        FROM Shoes s
        JOIN Models m ON s.model_id = m.id
        JOIN Brands b ON m.brand_id = b.id
        ORDER BY s.release_year DESC, b.name, m.name, s.edition";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Shoes Inventory</title>
    <!-- Link to external CSS -->
    <link rel="stylesheet" href="styles.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
</head>
<body>
    <div class="container">
        <h1>Shoes Inventory</h1>

        <!-- Shoes Table -->
        <?php
        if ($result->num_rows > 0) {
            echo "<table id='shoesTable' class='display'>";
            echo "<thead>
                    <tr>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Height</th>
                        <th>Edition</th>
                        <th>Condition</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Box</th>
                        <th>Release Year</th>
                        <th>Comments</th>
                        <th>StockX Link</th>
                        <th>GOAT Link</th>
                    </tr>
                  </thead>";
            echo "<tbody>";

            // Fetch and display each row of data
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["Brand"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Model"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Height"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Edition"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Condition"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Color"] ?? 'N/A') . "</td>";
                echo "<td>" . htmlspecialchars($row["Size"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Box"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["ReleaseYear"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Comments"] ?? 'N/A') . "</td>";
                echo "<td><a href='" . htmlspecialchars($row["StockXLink"]) . "' target='_blank'>StockX</a></td>";
                echo "<td>" . ($row["GoatLink"] ? "<a href='" . htmlspecialchars($row["GoatLink"]) . "' target='_blank'>GOAT</a>" : 'N/A') . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No shoes found in the inventory.</p>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
    <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- Link to external JavaScript -->
    <script src="scripts.js"></script>
</body>
</html>
