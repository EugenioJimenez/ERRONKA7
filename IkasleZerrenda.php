<?php
$con = mysqli_connect('localhost', 'root', '', 'donbosco_web_orria');

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have form fields with names: current_ikasleID, column_name, new_value
    $current_ikasleID = mysqli_real_escape_string($con, $_POST["current_ikasleID"]);
    $column_name = mysqli_real_escape_string($con, $_POST["column_name"]);
    $new_value = mysqli_real_escape_string($con, $_POST["new_value"]);

    // Validate JaiotzeData column
    if ($column_name == "JaiotzeData" && !empty($new_value)) {
        // Attempt to create a DateTime object based on a specific date format
        $dateObj = DateTime::createFromFormat('Y-m-d', $new_value);

        // Check if the creation was successful and the date is valid
        if (!$dateObj || $dateObj->format('Y-m-d') !== $new_value) {
            echo "Balio baliogabea jaiotze-datarako. Data balioduna izan behar du (YYYY-MM-DD).";
            exit; // or return an error message as needed
        }
    }

    // Validate Helbidea column
    if ($column_name == "Helbidea" && !empty($new_value)) {
        // Check if the new value is a valid email address
        if (!filter_var($new_value, FILTER_VALIDATE_EMAIL)) {
            echo "balio baliogabea helbiderako. Helbide elektroniko bat izan behar du.";
            exit; // or return an error message as needed
        }
    }

    // Validate Telefonoa column
    if ($column_name == "Telefonoa" && !empty($new_value)) {
        // Check if the new value is numeric
        if (!is_numeric($new_value)) {
            echo "Balio baliogabea telefonorako. Balio numerikoa izan behar du.";
            exit; // or return an error message as needed
        }

        // Check if the length of the numeric value is exactly 9
        if (strlen($new_value) !== 9) {
            echo "Balio baliogabea telefonorako. 9 digitu izan behar ditu.";
            exit; // or return an error message as needed
        }
    }

// Check if the form_action field is set to "update"
if ($_POST["form_action"] === "update") {
    // Update the database
    $updateSql = "UPDATE ikasleak SET $column_name = ? WHERE IkasleID = ?";
    $stmt = $con->prepare($updateSql);

    if ($stmt) {
        $stmt->bind_param("ss", $new_value, $current_ikasleID);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Datuak aldatu egin dira. ";
        } else {
            echo "Datuak ez dira aldatu. ";
        }

        $stmt->close();
    } else {
        echo "Update statement preparation failed. ";
    }
}

// Check if the delete_ikaslea field is set to "true"
if ($_POST["delete_ikaslea"] === "true") {
    // Perform the deletion logic here for related records in the child table
    $deleteChildSql = "DELETE FROM ebaluazioa WHERE IkasleID = ?";
    $deleteChildStmt = $con->prepare($deleteChildSql);

    if ($deleteChildStmt) {
        $deleteChildStmt->bind_param("s", $current_ikasleID);
        $deleteChildStmt->execute();
        $deleteChildStmt->close();
    } else {
        echo "Error deleting child records.";
    }

    // Now, proceed with deleting the parent record
    $deleteSql = "DELETE FROM ikasleak WHERE IkasleID = ?";
    $deleteStmt = $con->prepare($deleteSql);

    if ($deleteStmt) {
        $deleteStmt->bind_param("s", $current_ikasleID);
        $deleteStmt->execute();

        if ($deleteStmt->affected_rows > 0) {
            echo "Ikaslea ezabatu egin da.";
        } else {
            echo "Ezin izan da ikaslea ezabatu.";
        }

        $deleteStmt->close();
    } else {
        echo "Delete statement preparation failed.";
    }
} else {
    // Continue with the update logic (existing code)
}

}

// Retrieve data from the database
$sql = "SELECT IkasleID, Ikasleizena, Ikasleabizena, DATE_FORMAT(JaiotzeData, '%Y-%m-%d') AS JaiotzeData, Herria, Sexua, Telefonoa, Helbidea FROM ikasleak";
$result = $con->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Display and Update Database Data</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function fillFormData(ikasleID, columnName, ikasleizena, ikasleabizena) {
            document.getElementById("current_ikasleID").value = ikasleID;
            document.getElementById("ikasleizena").value = ikasleizena; // Assign Ikasleizena to hidden input
            document.getElementById("ikasleabizena").value = ikasleabizena; // Assign Ikasleabizena to hidden input
            // Dynamically set the selected option in the dropdown
            var dropdown = document.getElementById("column_name");
            for (var i = 0; i < dropdown.options.length; i++) {
                if (dropdown.options[i].value === columnName) {
                    dropdown.options[i].selected = true;
                    break;
                }
            }
        }
		function deleteIkaslea() {
			// Retrieve Ikasleizena and Ikasleabizena from hidden input fields
			var ikasleizena = document.getElementById("ikasleizena").value;
			var ikasleabizena = document.getElementById("ikasleabizena").value;

			// Confirm deletion with the retrieved data
			var confirmMessage = "Ziur zaude " + ikasleizena + " " + ikasleabizena + " datu hauek ezabatu nahi dituzula?";
			var confirmDelete = confirm(confirmMessage);
			if (confirmDelete) {
				// Set the value for deletion in the hidden field
				document.getElementById("delete_ikaslea").value = "true";
				
				// Submit the form
				document.forms[0].submit();
			}
		}

    </script>
</head>
<body>
    <h1>Ikasle Zerrenda</h1>
    
    <!-- Form for updating any column -->
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="update-form">
    
        <div class="form-group">
            <label for="current_ikasleID">IkasleID:</label>
            <input type="text" id="current_ikasleID" name="current_ikasleID" required>
        </div>

        <!-- Add hidden input fields for Ikasleizena and Ikasleabizena -->
        <input type="hidden" id="ikasleizena" name="ikasleizena">
        <input type="hidden" id="ikasleabizena" name="ikasleabizena">

        <div class="form-group">
            <label for="column_name">Aldatu nahi duzun datua:</label>
            <select id="column_name" name="column_name" required>
                <option value="Ikasleizena">Ikasleizena</option>
                <option value="Ikasleabizena">Ikasleabizena</option>
                <option value="JaiotzeData">JaiotzeData</option>
                <option value="Herria">Herria</option>
                <option value="Sexua">Sexua</option>
                <option value="Telefonoa">Telefonoa</option>
                <option value="Helbidea">Helbidea</option>
                <!-- Add more options for other columns -->
            </select>
        </div>
        
        <div class="form-group">
            <label for="new_value">Datu berria:</label>
            <input type="text" id="new_value" name="new_value" required>
        </div>
        
        <div class="form-buttons">
            <button type="submit" value="Aldatu datua" class="submit-button">Aldatu Datua</button>
            <button type="button" onclick="deleteIkaslea()" class="delete-button">Ezabatu Ikaslea</button>
        </div>
        
        <!-- Hidden input for deletion -->
        <input type="hidden" id="delete_ikaslea" name="delete_ikaslea" value="false">
        <input type="hidden" name="form_action" value="update">
    </form>

    <!-- Display data in a table -->
    <table id="studentTable" border="1">
        <tr>
            <!--<th>IkasleID</th>-->
            <th>Ikasleizena</th>
            <th>Ikasleabizena</th>
            <th>Jaiotzedata</th>
            <th>Herria</th>
            <th>Sexua</th>
            <th>Telefonoa</th>
            <th>Helbidea</th>
        </tr>
         <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";

                // Display IkasleID as a clickable cell
                echo "<td hidden onclick=\"fillFormData('" . htmlspecialchars($row["IkasleID"]) . "', 'IkasleID', '" . htmlspecialchars($row["Ikasleizena"]) . "', '" . htmlspecialchars($row["Ikasleabizena"]) . "')\">" . htmlspecialchars($row["IkasleID"]) . "</td>";

                // Display other columns as clickable cells
                foreach ($row as $column => $value) {
                    if ($column !== "IkasleID") {
                        echo "<td onclick=\"fillFormData('" . htmlspecialchars($row["IkasleID"]) . "', '" . htmlspecialchars($column) . "', '" . htmlspecialchars($row["Ikasleizena"]) . "', '" . htmlspecialchars($row["Ikasleabizena"]) . "')\">" . htmlspecialchars($value) . "</td>";
                    }
                }

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No data found</td></tr>";
        }
        $con->close();
        ?>
    </table>
</body>
</html>
