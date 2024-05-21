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
	<!-- Karaktere multzorako eta ikusmenerako metadatuak -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Web orriaren izenburua -->
    <title>Ikasle Alta</title>
	<!-- Kanpoko estilo-orrira estekatzea -->
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
	<!-- Ikasleen goiburu-atala -->
    <div class="IkasleTop">
        <h1>Modulo Alta</h1>
        <h3>Moduloaren datuak aukeratu:</h3>
    </div>
	<!-- Edukiaren edukiontzi nagusia -->
    <div class="container">
		<!-- Datuak sartzeko formularioa -->
        <form id="myForm" method="post" action="">
            <label for="ModuloZbk">Modulo Zenbakia:</label>
            <input type="text" id="ModuloZbk" name="ModuloZbk" placeholder="Zure Modulo Zenbakia...">
            <br>
			<!-- Menua aukeratzeko datua --> 
            <label for="ModuloIzena">Modulo Izena:</label>
            <select id="ModuloIzena" name="ModuloIzena">
                <option disabled selected hidden>Aukeratu moduloa</option> <!-- Desgaitua -->
                <option value="Ibilgailuen egiturak">Ibilgailuen egiturak</option>
                <option value="Motor termikoak eta sistema osagarriak">Motor termikoak eta sistema osagarriak</option>
                <option value="Ingeles teknikoa">Ingeles teknikoa</option>
				<option value="Automozioko proiektua">Automozioko proiektua</option>
            </select>
            <br>
			<!-- Menua aukeratzeko datua -->
            <label for="ModuloOrduak">Modulo Orduak:</label>
            <select id="ModuloOrduak" name="ModuloOrduak">
                <option disabled selected hidden>AukeratuOrduak</option> <!-- Desgaitua-->
                <option value="132 ordu">132 ordu</option>
                <option value="231 ordu">231 ordu</option>
                <option value="40 ordu">40 ordu</option>
				<option value="50 ordu">50 ordu</option>
            </select>
            <br>
			<!-- XML datuak gorde eta deskargatzeko botoiak -->
            <input type="submit" value="Gorde Datu Basean" onclick="guardarDatos()">
			<?php
			// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs to prevent SQL injection
    $ModuloZbk = mysqli_real_escape_string($con, $_POST['ModuloZbk']);
    $ModuloIzena = mysqli_real_escape_string($con, $_POST['ModuloIzena']);
    $ModuloOrduak = mysqli_real_escape_string($con, $_POST['ModuloOrduak']);
	

	$sql = "INSERT INTO moduluak (ModuloID, Moduloizena, Moduloorduak)
            VALUES ('$ModuloZbk', '$ModuloIzena', '$ModuloOrduak')";
    if (mysqli_query($con, $sql)) {
        echo '<div class="success">""Datu-basean ondo txertatu dira datuak. ""<span class="success-close" onclick="this.parentElement.style.display=\'none\';">&times;<span></div>';
        // Clear the form fields after successful insertion
        $_POST['ModuloZbk'] = '';
        $_POST['ModuloIzena'] = '';
        $_POST['ModuloOrduak'] = '';
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
		// Arreglo para almacenar datos del módulo guardados
        var datosGuardados = [];
		
		// Función para guardar datos del módulo
        function guardarDatos() {
			// Obtener valores de los campos del formulario
            var moduloZbk = document.getElementById('ModuloZbk').value;
            var moduloIzena = document.getElementById('ModuloIzena').value;
            var moduloOrduak = document.getElementById('ModuloOrduak').value;
			
			// Verificar si todos los campos están completos
            if (moduloZbk && moduloIzena && moduloOrduak) {
				document.getElementById('myForm').submit();
                alert('Dato guardado correctamente.');
            } else {
                alert('Completa todos los campos antes de guardar.');
            }
        }
    </script>
</body>
</html>

