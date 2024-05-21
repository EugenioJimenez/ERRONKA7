<?php
$con = mysqli_connect('localhost', 'root', '', 'donbosco_web_orria');

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Irakasle Alta</title>
    <link rel="stylesheet" href="Itxura.css">
</head>

<body>
    <div class="IkasleTop">
        <h1>Irakasle Alta</h1>
        <h3>Irakasle datuak sartu:</h3>
    </div>
    <div class="container">
        <form id="myForm" method="post" action="">
            <label for="NAN">NAN:</label>
            <input type="text" id="NAN" name="nan" placeholder="Zure NAN...">
            <br>
            <label for="Izena">Izena:</label>
            <input type="text" id="Izena" name="izena" placeholder="Zure izena...">
            <br>
            <label for="Abizena">Abizenak:</label>
            <input type="text" id="Abizena" name="abizena" placeholder="Zure abizena...">
            <br>
            <label for="jaiotzedata">Jaiotze Data:</label>
            <input type="date" id="Jaiotzedata" name="jaiotzedata"><br>
            <label for="Herria">Herria:</label>
            <input type="text" id="Herria" name="herria" placeholder="Zure herria..."><br>
            <p>Sexua:</p>
            <label for="gizonezkoa">Gizonezkoa</label>
            <input type="radio" id="gizonezkoa" name="sexua" value="Gizonezkoa"><br>
            <label for="emakumezkoa">Emakumezkoa</label>
            <input type="radio" id="emakumezkoa" name="sexua" value="Emakumezkoa"><br>
            <label for="definitugabe">Definitu Gabea</label>
            <input type="radio" id="definitugabe" name="sexua" value="DefinituGabea"><br><br>
			<label for="Telefonoa">Telefonoa:</label>
            <input type="tel" id="Telefonoa" name="telefonoa" placeholder="Zure telefonoa..."><br>
            <label for="emails">Helbidea:</label>
            <input type="email" id="emails" name="emails" multiple placeholder="Zure korreo elektronikoa...">

            <input type="submit" value="Gorde Datu Basean" onclick="guardarDatos()">
			<?php
			// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs to prevent SQL injection
    $nan = mysqli_real_escape_string($con, $_POST['nan']);
    $izena = mysqli_real_escape_string($con, $_POST['izena']);
    $abizena = mysqli_real_escape_string($con, $_POST['abizena']);
    $jaiotzedata = mysqli_real_escape_string($con, $_POST['jaiotzedata']);
    $herria = mysqli_real_escape_string($con, $_POST['herria']);
	
	// Check if a radio button is selected
    $sexua = isset($_POST['sexua']) ? mysqli_real_escape_string($con, $_POST['sexua']) : '';
	
	$telefonoa = mysqli_real_escape_string($con, $_POST['telefonoa']);
	$emails = mysqli_real_escape_string($con, $_POST['emails']);
	

	$sql = "INSERT INTO irakasleak (IrakasleID, Irakasleizena, Irakasleabizena, Jaiotzedata, Herria, Sexua, Telefonoa, Helbidea)
            VALUES ('$nan', '$izena', '$abizena', '$jaiotzedata', '$herria', '$sexua', '$telefonoa', '$emails')";
    if (mysqli_query($con, $sql)) {
        echo "Data inserted successfully into the database.";
        // Clear the form fields after successful insertion
        $_POST['nan'] = '';
        $_POST['izena'] = '';
        $_POST['abizena'] = '';
        $_POST['jaiotzedata'] = '';
        $_POST['herria'] = '';
        $_POST['sexua'] = '';
        $_POST['telefonoa'] = '';
        $_POST['emails'] = '';
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}

// Close the database connection
$con->close();
?>
        </form>
    </div>
    <script>
		// Arreglo para almacenar los datos guardados
        var datosGuardados = [];
		
		// Función para guardar los datos ingresados en el formulario
		function guardarDatos() {
				var nan = document.getElementById('NAN').value;
				var izena = document.getElementById('Izena').value;
				var abizena = document.getElementById('Abizena').value;
				var jaiotzedata = document.getElementById('Jaiotzedata').value;
				var herria = document.getElementById('Herria').value;
				var sexua = document.querySelector('input[name="sexua"]:checked');
				var telefonoa = document.getElementById('Telefonoa').value;
				var emails = document.getElementById('emails').value;
				
				// Validations
				if (!validateNAN(nan)) {
				alert('NAN ez da baliozkoa.');
				return;
				}
				
				if (!validateTelefonoa(telefonoa)) {
					alert('Telefonoa ez da baliozkoa.');
					return;
				}

				if (!validateEmail(emails)) {
					alert('Helbidea ez da baliozkoa.');
					return;
				}

				if (nan && izena && abizena && jaiotzedata && herria && sexua && telefonoa && emails ) {
					// Crear un nuevo objeto con los datos ingresados
					var nuevoDato = {
						nan: nan,
						izena: izena,
						abizena: abizena,
						sexua: sexua.value,
						telefonoa: telefonoa,
						emails: emails
					};
					
					actualizarTabla();
					
					document.getElementById('myForm').submit();
					// Agregar el nuevo dato al arreglo
					 datosGuardados.push(nuevoDato);
				    // Actualiza la tabla
			
				   

				} else {
					alert('Completa todos los campos antes de guardar.');
				}
			}
			function validateNAN(nan) {
			// El NAN debe contener exactamente 8 dígitos seguidos por una letra
			var nanRegex = /^\d{8}[a-zA-Z]$/;
			return nanRegex.test(nan);
			}
			// Función para validar el formato del número de teléfono
			function validateTelefonoa(telefonoa) {
				// Puedes personalizar tu lógica de validación según tus requisitos
				var telefonoRegex = /^\d{9}$/;
				return telefonoRegex.test(telefonoa);
			}

			// Función para validar el formato de la dirección de correo electrónico
			function validateEmail(email) {
				// Puedes personalizar tu lógica de validación según tus requisitos
				var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
				return emailRegex.test(email);
			}

        
		
		
		
    </script>
</body>
</html>
