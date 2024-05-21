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
    <title>Ikasle Alta</title>
    <link rel="stylesheet" href="Itxura.css">
<style>
/* Centered styles for the error message */

.error {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #fff;
    font-weight: bold;
    background: linear-gradient(135deg, #ff5366, #ff7d64);
    padding: 40px;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    font-family: 'Montserrat', sans-serif;
    transition: background 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 80%; /* Adjust the width as needed */
    max-width: 600px;
    overflow: hidden;
    border: 2px solid #fff;
}

/* Hover effect for error messages without movement */
.error:hover {
    background: linear-gradient(135deg, #ff5366, #ff7d64);
}


.error-close {
    cursor: pointer;
    color: #fff;
    font-size: 24px;
    transition: color 0.3s ease;
    position: absolute;
    top: 15px;
    right: 15px;
}

.error-close:hover {
    color: #fff;
    transform: scale(1.3);
}

.error p {
    margin-top: 20px;
    font-size: 20px;
    line-height: 1.6;
    max-width: 80%;
    margin: 0 auto;
}

.error-icon {
    font-size: 100px;
    margin-bottom: 20px;
    color: #fff;
}

.error::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    z-index: -1;
}

.error::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    height: 20px;
    background: rgba(0, 0, 0, 0.2);
    border-radius: 20px;
    z-index: -1;
}

.error p {
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.error:hover::before,
.error:hover::after {
    transition: border-radius 0.3s ease;
    border-radius: 22px;
}

.error::before {
    content: "";
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
    border: 3px solid #fff;
    border-radius: 23px;
    z-index: -2;
}

@keyframes sparkle {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-8px);
    }
}

.error::before {
    animation: sparkle 2s infinite;
}

@keyframes gradientShift {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

.error {
    background-size: 200% 200%;
    animation: gradientShift 5s infinite;
}

@keyframes glow {
    0% {
        box-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
    }
    50% {
        box-shadow: 0 0 30px rgba(255, 255, 255, 0.9);
    }
    100% {
        box-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
    }
}

.error:hover {
    animation: glow 2s infinite;
}







	
/* Centered styles for the success message */

.success {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #fff;
    font-weight: bold;
    background: linear-gradient(135deg, #4caf50, #8bc34a); /* Change red to green */
    padding: 40px;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    font-family: 'Montserrat', sans-serif;
    transition: background 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 80%; /* Adjust the width as needed */
    max-width: 600px;
    overflow: hidden;
    border: 2px solid #fff;
}

/* Hover effect for success messages without movement */
.success:hover {
    background: linear-gradient(135deg, #4caf50, #8bc34a); /* Change red to green */
}

.success-close {
    cursor: pointer;
    color: #fff;
    font-size: 24px;
    transition: color 0.3s ease;
    position: absolute;
    top: 15px;
    right: 15px;
}

.success-close:hover {
    color: #fff;
    transform: scale(1.3);
}

.success p {
    margin-top: 20px;
    font-size: 20px;
    line-height: 1.6;
    max-width: 80%;
    margin: 0 auto;
}

.success-icon {
    font-size: 100px;
    margin-bottom: 20px;
    color: #fff;
}

.success::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    z-index: -1;
}

.success::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    height: 20px;
    background: rgba(0, 0, 0, 0.2);
    border-radius: 20px;
    z-index: -1;
}

.success p {
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.success:hover::before,
.success:hover::after {
    transition: border-radius 0.3s ease;
    border-radius: 22px;
}

.success::before {
    content: "";
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
    border: 3px solid #fff;
    border-radius: 23px;
    z-index: -2;
}

@keyframes sparkle {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-8px);
    }
}

.success::before {
    animation: sparkle 2s infinite;
}

@keyframes gradientShift {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

.success {
    background-size: 200% 200%;
    animation: gradientShift 5s infinite;
}

@keyframes glow {
    0% {
        box-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
    }
    50% {
        box-shadow: 0 0 30px rgba(255, 255, 255, 0.9);
    }
    100% {
        box-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
    }
}

.success:hover {
    animation: glow 2s infinite;
}

</style>


</head>
<body>
    <div class="IkasleTop">
        <h1>Ikasle Alta</h1>
        <h3>Ikasle datuak sartu:</h3>
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
            <input type="email" id="emails" name="emails" placeholder="Zure korreo elektronikoa...">

            <!-- Botones para guardar y descargar datos XML -->
            <input type="submit" value="Gorde Datu Basean" onclick="guardarDatos()">
			<?php
function validateNAN($nan) {
    // El NAN debe contener exactamente 8 dígitos seguidos por una letra
    $nanRegex = '/^\d{8}[a-zA-Z]$/';
    return preg_match($nanRegex, $nan);
}
function validateTelefonoa($telefonoa) {
	// Puedes personalizar tu lógica de validación según tus requisitos
	$telefonoaRegex = '/^\d{9}$/';
	return preg_match ($telefonoaRegex, $telefonoa);
}
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

	if (!validateNAN($nan)) {
    echo '<div class="error"> <span class="error-icon">!</span> "NAN ez da baliozkoa."<span class="error-close" onclick="this.parentElement.style.display=\'none\';">&times;</span></div>';
        exit; // Do not proceed with saving to the database
    }
	
	if (!validateTelefonoa($telefonoa)) {
		echo '<div class="error"> <span class="error-icon">!</span> "Telefonoa ez da baliozkoa."<span class="error-close" onclick="this.parentElement.style.display=\'none\';">&times;</span></div>';
		exit;
	}
	
	$sql = "INSERT INTO ikasleak (IkasleID, Ikasleizena, Ikasleabizena, Jaiotzedata, Herria, Sexua, Telefonoa, Helbidea)
            VALUES ('$nan', '$izena', '$abizena', '$jaiotzedata', '$herria', '$sexua', '$telefonoa', '$emails')";
    if (mysqli_query($con, $sql)) {
        echo '<div class="success">""Datu-basean ondo txertatu dira datuak. ""<span class="success-close" onclick="this.parentElement.style.display=\'none\';">&times;<span></div>';
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
        echo '<div class="error"> "Error: " . $sql . "<br>" . mysqli_error($con) <span class="error-close" onclick="this.parentElement.style.display=\'none\';">&times;</span></div>';
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
		
		function validateNAN(nan) {
			// El NAN debe contener exactamente 8 dígitos seguidos por una letra
			var nanRegex = /^\d{8}[a-zA-Z]$/;
			return nanRegex.test(nan);
		}
		
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
                document.getElementById('myForm').submit();
                // Agregar el nuevo dato al arreglo

               

            } else {
                alert('Completa todos los campos antes de guardar.');
            }
        }


        
    </script>
</body>
</html>
