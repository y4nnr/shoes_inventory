<?php
// inventory.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connection.php';

$sql = "SELECT
            s.id AS ShoeID,
            b.name AS Brand,
            m.name AS Model,
            m.height AS Height,
            s.edition AS Edition,
            s.shoe_condition AS `Condition`,
            s.color AS Color,
            s.size AS Size,
            s.box AS Box,
            s.picture_url AS PictureURL,
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
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
</head>
<body>
    <div class="container">
	<div class="title-container">Shoes Inventory</div>

        <?php
        if ($result->num_rows > 0) {
            echo "<table id='shoesTable' class='display'>";
            echo "<thead>
                    <tr>
                        <th>Picture</th>
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

            while ($row = $result->fetch_assoc()) {
                echo "<tr class='shoe-row' data-shoeid='".htmlspecialchars($row["ShoeID"])."'>";
                echo "<td><img src='".htmlspecialchars($row["PictureURL"] ?? 'placeholder.jpg')."' alt='Shoe Image' class='shoe-thumbnail' data-fullsize='".htmlspecialchars($row["PictureURL"])."'></td>";
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

                // StockX Button
                echo "<td>";
                if (!empty($row["StockXLink"])) {
                    echo "<a href='" . htmlspecialchars($row["StockXLink"]) . "' target='_blank' class='stockx-button'>StockX</a>";
                } else {
                    echo "N/A";
                }
                echo "</td>";

                // GOAT Button
                echo "<td>";
                if (!empty($row["GoatLink"])) {
                    echo "<a href='" . htmlspecialchars($row["GoatLink"]) . "' target='_blank' class='goat-button'>GOAT</a>";
                } else {
                    echo "N/A";
                }
                echo "</td>";

                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No shoes found in the inventory.</p>";
        }
        $conn->close();
        ?>
    </div>

    <!-- Shoe Details Modal -->
    <div id="shoeModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="shoeDetails"></div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal">
        <div class="image-modal-content">
            <span class="close">&times;</span>
            <img src="" alt="Full-size shoe image">
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="scripts.js"></script>
</body>
</html>
