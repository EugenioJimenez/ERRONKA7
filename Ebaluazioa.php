<?php
$con = mysqli_connect('localhost', 'root', '', 'donbosco_web_orria');

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}


// Handle form submission 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if (isset($_POST["form_action2"]) && ($_POST["form_action2"] === "update" OR $_POST["form_action2"] === "delete")){ 
			// Assuming you have form fields with names: current_ikasleID, column_name, new_value
			$current_ikasleID = mysqli_real_escape_string($con, $_POST["current_ikasleID"]);
			$current_moduloID = mysqli_real_escape_string($con, $_POST["current_moduloID"]);
			$column_name = mysqli_real_escape_string($con, $_POST["column_name"]);
			$new_value = mysqli_real_escape_string($con, $_POST["new_value"]);

			
			// Check if the form_action field is set to "update"
			if ($_POST["form_action2"] === "update"){ 	
				// Update the database
				// Update the database
			$updateSql = "UPDATE ebaluazioa SET $column_name = ? WHERE IkasleID = ? AND ModuloID = ?";
			$stmt = $con->prepare($updateSql);

			if ($stmt) {
				$stmt->bind_param("sss", $new_value, $current_ikasleID, $current_moduloID);
				$stmt->execute();

				if ($stmt->affected_rows > 0) {
					echo "Datuak aldatu egin dira. ";
				} else {
					echo "Datuak ez dira aldatu. ";
				}

				$stmt->close();
			} else {
				echo "Update statement preparation failed: " . $con->error;
			}
			}

			// Check if the delete_ebaluazioa field is set to "true"
			if ($_POST["form_action2"] === "delete") {

				$deleteSql = "DELETE FROM ebaluazioa WHERE IkasleID = ? AND ModuloID = ?";
				$deleteStmt = $con->prepare($deleteSql);

				if ($deleteStmt) {
					$deleteStmt->bind_param("ss", $current_ikasleID, $current_moduloID);
					$deleteStmt->execute();

					if ($deleteStmt->affected_rows > 0) {
						echo "ebaluazioa ezabatu egin da.";
					} else {
						echo "Ezin izan da ebaluazioa ezabatu.";
					}

					$deleteStmt->close();
				} else {
					echo "Delete statement preparation failed: " . $con->error;
				}
			} else {
				// Continue with the update logic (existing code)
			}
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Database Data</title>
	<link rel="stylesheet" href="style.css">
	<script>
    function fillFormData(ikasleID, moduloID, columnName) {
        document.getElementById("current_ikasleID").value = ikasleID;
		document.getElementById("current_moduloID").value = moduloID;
        // Dynamically set the selected option in the dropdown
        var dropdown = document.getElementById("column_name");
        for (var i = 0; i < dropdown.options.length; i++) {
            if (dropdown.options[i].value === columnName) {
                dropdown.options[i].selected = true;
                break;
            }
        }

        // Populate the new_value input with the current cell value
        var table = document.getElementById("studentTable");
        for (var i = 1, row; row = table.rows[i]; i++) {
            for (var j = 1, col; col = row.cells[j]; j++) {
                if (col.onclick && col.onclick.name === "fillFormData" && col.innerHTML === ikasleID) {
                    document.getElementById("new_value").value = row.cells[j].innerHTML;
                }
            }
        }
    }

    function deleteEbaluazioa() {
        var confirmDelete = confirm("Ziur zaude datu hauek ezabatu nahi dituzula?");
        if (confirmDelete) {
            document.getElementById("form_action2").value = "delete";
            document.forms["frmSecundario"].submit();
        }
    }
		
	function updateEbaluazioa() {
            document.getElementById("form_action2").value = "update";
            document.forms["frmSecundario"].submit();
        
    }
	</script>

</head>

<body>
    <h1>Ebaluazioa</h1>

    <form method="post" action="" class="update-form">
        <label for="Data1">Ikaslearen Izena:</label>
        <select id="Data1" name="Data1">
		<?php
            // Fetch Ikasle data from the database
            $sql = "SELECT IkasleID, Ikasleizena FROM Ikasleak"; // Adjust based on your database schema
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['IkasleID']}'>{$row['Ikasleizena']}</option>";
                }
            } else {
                echo "<option>No results</option>";
            }
            ?>
        </select>

        <label for="Data2">Moduluaren Izena:</label>
        <select id="Data2" name="Data2">
		<?php
            // Fetch Modulo data from the database
            $sql = "SELECT ModuloID, Moduloizena FROM moduluak"; // Adjust based on your database schema
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['ModuloID']}'>{$row['Moduloizena']} - {$row['ModuloID']}</option>";
                }
            } else {
                echo "<option>No results</option>";
            }

            ?>
        </select>

        <h3>Idatzi Nota eta Faltak</h3>
        <label for="notaInput">Nota:</label>
        <input type="number" id="notaInput" name="notaInput" min="0" max="10">
        <label for="faltakInput">Falta/k:</label>
        <input type="number" id="faltakInput" name="faltakInput" min="0" max="200">
        <br>

		<div class="form-buttons">
        <button type="submit" value="Gorde Ebaluazioa" name="form_action" class="submit-button">Gorde Ebaluazioa</button>	
		</div>
    </form>

<?php
// Check if the form is submitted
if (isset($_POST['form_action'])) {
    // Retrieve form data (primary keys)
    $data1_id = $_POST['Data1'];
    $data2_id = $_POST['Data2'];
    $nota = $_POST['notaInput'];
    $faltak = $_POST['faltakInput'];


    // Check if the foreign key values exist in the referenced tables
    $check_sql1 = "SELECT IkasleID FROM Ikasleak WHERE IkasleID = '$data1_id'";
    $check_sql2 = "SELECT ModuloID FROM moduluak WHERE ModuloID = '$data2_id'";

    $result1 = mysqli_query($con, $check_sql1);
    $result2 = mysqli_query($con, $check_sql2);

    if (mysqli_num_rows($result1) === 0 || mysqli_num_rows($result2) === 0) {
        echo "Error: Foreign key values do not exist in the referenced tables.";
    } else {
        // Insert the selected primary keys into the ebaluazioa table
        $sql = "INSERT INTO ebaluazioa (IkasleID, ModuloID, Nota, Faltak) VALUES ('$data1_id', '$data2_id', '$nota', '$faltak')";

        if (mysqli_query($con, $sql)) {
            echo '<div class="success">Datu-basean ondo txertatu dira datuak.<span class="success-close" onclick="this.parentElement.style.display=\'none\';">&times;</span></div>';
        } else {
            echo '<div class="error">Error: ' . $sql . '<br>' . mysqli_error($con) . '<span class="error-close" onclick="this.parentElement.style.display=\'none\';">&times;</span></div>';
        }
    }

    // Close the connection after inserting data
    mysqli_close($con);
}

// Re-open the connection to fetch data for the table
$con = mysqli_connect('localhost', 'root', '', 'donbosco_web_orria');

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data for the table (adjust the query based on your database schema)
$sql = "SELECT e.IkasleID, i.Ikasleizena, e.ModuloID, m.Moduloizena, e.Nota, e.Faltak FROM ebaluazioa e
        INNER JOIN Ikasleak i ON e.IkasleID = i.IkasleID
        INNER JOIN moduluak m ON e.ModuloID = m.ModuloID";
$result = $con->query($sql);
?>


	<!-- Add this section after the PHP code for inserting data -->
	<div class="BichoLover">
	<table id="studentTable" border="1">
		<tr>
			<th>IkasleID</th>
			<th>ModuloID</th>
			<th>IkasleIzena</th>
			<th>Moduloizena</th>
			<th>Nota</th>
			<th>Faltak</th>
		</tr>
		<?php
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				echo "<tr>";
                // Display IkasleID and ModuloID as clickable cells
                echo "<td onclick=\"fillFormData('" . htmlspecialchars($row["IkasleID"]) . "', '" . htmlspecialchars($row["ModuloID"]) . "', 'IkasleID')\">" . htmlspecialchars($row["IkasleID"]) . "</td>";
                echo "<td onclick=\"fillFormData('" . htmlspecialchars($row["IkasleID"]) . "', '" . htmlspecialchars($row["ModuloID"]) . "', 'ModuloID')\">" . htmlspecialchars($row["ModuloID"]) . "</td>";

                // Display other columns as clickable cells
                foreach ($row as $column => $value) {
                    if ($column !== "IkasleID" && $column !== "ModuloID") {
                        echo "<td onclick=\"fillFormData('" . htmlspecialchars($row["IkasleID"]) . "', '" . htmlspecialchars($row["ModuloID"]) . "', '" . htmlspecialchars($column) . "')\">" . htmlspecialchars($value) . "</td>";
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
	</div>
	
		<!-- Form for updating selected data -->
	<form method="post" id= "frmSecundario" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="update-form">
		<div class="form-group">
			<label for="current_ikasleID">IkasleID:</label>
			<input type="text" id="current_ikasleID" name="current_ikasleID" readonly>
		</div>
		
        <div class="form-group">
			<label for="current_moduloID">ModuloID:</label>
			<input type="text" id="current_moduloID" name="current_moduloID" required>
		</div>		

		<div class="form-group">
			<label for="column_name">Aldatu nahi duzun datua:</label>
			<select id="column_name" name="column_name" required>
				<option value="Nota">Nota</option>
				<option value="Faltak">Faltak</option>
				<!-- Add more options for other columns -->
			</select>
		</div>

		<div class="form-group">
			<label for="new_value">Datu berria:</label>
			<input type="text" id="new_value" name="new_value">
		</div>

		<div class="form-buttons">
			<button type="submit" onclick="updateEbaluazioa()" class="submit-button">Aldatu Datua</button>
			<button type="button" onclick="deleteEbaluazioa()" class="delete-button">Ezabatu Ebaluazioa</button>
		</div>

		<!-- Hidden input for form_action -->
		<input type="hidden" id="form_action2" name="form_action2" value="ezBidali">
				
	</form>


</body>
</html>
