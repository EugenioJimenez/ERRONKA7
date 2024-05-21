<?php
$con = mysqli_connect('localhost', 'root', '', 'donbosco_web_orria');

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have form fields with names: current_ikasleID, column_name, new_value
    $current_ModuloID = mysqli_real_escape_string($con, $_POST["current_ModuloID"]);
    $column_name = mysqli_real_escape_string($con, $_POST["column_name"]);
    $new_value = mysqli_real_escape_string($con, $_POST["new_value"]);

// Check if the form_action field is set to "update"
if ($_POST["form_action"] === "update") {
    // Update the database
    $updateSql = "UPDATE moduluak SET $column_name = ? WHERE ModuloID = ?";
    $stmt = $con->prepare($updateSql);

    if ($stmt) {
        $stmt->bind_param("ss", $new_value, $current_ModuloID);
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

// Check if the delete_modulo field is set to "true"
if ($_POST["delete_modulo"] === "true") {
    // Delete related records in ebaluazioa table
    $deleteEbaluazioaSql = "DELETE FROM ebaluazioa WHERE ModuloID = ?";
    $deleteEbaluazioaStmt = $con->prepare($deleteEbaluazioaSql);

    if ($deleteEbaluazioaStmt) {
        $deleteEbaluazioaStmt->bind_param("s", $current_ModuloID);
        $deleteEbaluazioaStmt->execute();
        $deleteEbaluazioaStmt->close();
    } else {
        echo "Delete ebaluazioa statement preparation failed: " . $con->error;
    }

    // Now, proceed with deleting the record in moduluak table
    $deleteSql = "DELETE FROM moduluak WHERE ModuloID = ?";
    $deleteStmt = $con->prepare($deleteSql);

    if ($deleteStmt) {
        $deleteStmt->bind_param("s", $current_ModuloID);
        $deleteStmt->execute();

        if ($deleteStmt->affected_rows > 0) {
            echo "Moduloa ezabatu egin da.";
        } else {
            echo "Ezin izan da moduloa ezabatu.";
        }

        $deleteStmt->close();
    } else {
        echo "Delete statement preparation failed: " . $con->error;
    }
}


}


// Retrieve data from the database
$sql = "SELECT ModuloID, Moduloizena, Moduloorduak FROM moduluak";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Display and Update Database Data</title>
    <link rel="stylesheet" href="style.css">
	<script>
		function fillFormData(ModuloID, columnName) {
			document.getElementById("current_ModuloID").value = ModuloID;

			// Dynamically set the selected option in the dropdown
			var dropdown = document.getElementById("column_name");
			for (var i = 0; i < dropdown.options.length; i++) {
				if (dropdown.options[i].value === columnName) {
					dropdown.options[i].selected = true;
					break;
				}
			}
		}

		function deleteModulo() {
			var confirmDelete = confirm("Ziur zaude datu hauek ezabatu nahi dituzula?");
			if (confirmDelete) {
				// Set the value for deletion in the hidden field
				document.getElementById("delete_modulo").value = "true";
				
				// Submit the form
				document.forms[0].submit();
			}
		}		
	</script>
</head>
<body>
    <h1>Modulo Zerrenda</h1>
    
    <!-- Form for updating any column -->
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="update-form">
	
		<div class="form-group">
			<label for="current_ModuloID">ModuloID:</label>
			<input type="text" id="current_ModuloID" name="current_ModuloID" required>
		</div>
		
		<div class="form-group">
			<label for="column_name">Aldatu nahi duzun datua:</label>
			<select id="column_name" name="column_name" required>
				<option value="Moduloizena">Moduloizena</option>
				<option value="Moduloorduak">Moduloorduak</option>
				<!-- Add more options for other columns -->
			</select>
		</div>
		
		<div class="form-group">
			<label for="new_value">Datu berria:</label>
			<input type="text" id="new_value" name="new_value" required>
		</div>
		
		<div class="form-buttons">
			<button type="submit" value="Aldatu datua" class="submit-button">Aldatu Datua</button>
			<button type="button" onclick="deleteModulo()" class="delete-button">Ezabatu Moduloa</button>
		</div>
		
		<!-- Hidden input for deletion -->
		<input type="hidden" id="delete_modulo" name="delete_modulo" value="false">
		<input type="hidden" name="form_action" value="update">
    </form>

    <!-- Display data in a table -->
    <table id="studentTable2" border="1">
        <tr>
            <th>ModuloID</th>
            <th>Moduloizena</th>
            <th>Moduloorduak</th>

        </tr>
         <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";

                // Display IrakasleID as a clickable cell
                echo "<td onclick=\"fillFormData('" . htmlspecialchars($row["ModuloID"]) . "', 'ModuloID')\">" . htmlspecialchars($row["ModuloID"]) . "</td>";

                // Display other columns as clickable cells
                foreach ($row as $column => $value) {
                    if ($column !== "ModuloID") {
                        echo "<td onclick=\"fillFormData('" . htmlspecialchars($row["ModuloID"]) . "', '" . htmlspecialchars($column) . "')\">" . htmlspecialchars($value) . "</td>";
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