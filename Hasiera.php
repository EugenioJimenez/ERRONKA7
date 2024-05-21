<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <title>DonBosco</title>
    <link rel="stylesheet" href="Itxura.css">
</head>
<body>
	 <!-- Contenedor principal de la página -->
    <div class="CR7">
		<!-- Sección superior con el título y el logo de Don Bosco -->
        <div class="Top">
            <h1 class="titulo">DON BOSCO</h1>
            <img class="logo" src="Argazkia/DonBoscoLogo.png" alt="Don Bosco Logo">
        </div>
		<!-- Menú horizontal desplegable -->
        <div class="Horizontal">
            <button class="Menu"><a href="Hasiera2.html" target="ABC">Hasiera</a></button>
        </div>
        <div class="Horizontal">
            <button class="Menu">Ikasle</button>
            <div class="Submenu">
                <a href="IkasleAlta.php" target="ABC">Ikasle Alta</a>
                <a href="IkasleZerrenda.php"target="ABC">Ikasle Zerrenda</a>
            </div>
        </div>
        <div class="Horizontal">
            <button class="Menu">Irakasle</button>
            <div class="Submenu">
                <a href="IrakasleAlta.php" target="ABC">Irakasle alta eta tabla</a>
                <a href="IrakasleZerrenda.php" target="ABC">Irakasle zerrenda</a>
            </div>
        </div>
        <div class="Horizontal">
            <button class="Menu">Moduloak</button>
            <div class="Submenu">
                <a href="ModuloAlta.php" target="ABC">Modulo alta eta tabla</a>
                <a href="ModuloZerrenda.php" target="ABC">Moduloen zerrenda</a>
            </div>
        </div>
        <div class="Horizontal">
            <button class="Menu"><a href="Ebaluazioa.php" target="ABC">Ebaluazioa</button>
        </div>
    </div>
	<!-- Contenedor de iframe -->
    <div class="IF">
        <iframe src="Hasiera2.html" name="ABC"></iframe>
    </div>
    <div class="Sareak">
		<!-- Pie de Pagina -->
        <footer>
			<!-- Seccion/Lista de redes sociales -->
            <ul class="Sozial">
                <h2 class="SareSozialak">SARE SOZIALAK</h2>
                <li>
                    <a href="https://www.instagram.com/fpdonboscolh/" target="_blank">
                        <img class="Txikia" src="Argazkia/Instagram.png" alt="Instagram logo">
                    </a>
                </li>
                <li>
                    <a href="https://twitter.com/FPdonboscoLH" target="_blank">
                        <img class="Txikia" src="Argazkia/Twitter.png" alt="Twitter logo">
                    </a>
                </li>
                <li>
                    <a href="https://www.youtube.com/channel/UCOs7j2eRzfXbFgBOOs1-9TQ" target="_blank">
                        <img class="Txikia" src="Argazkia/Youtube.png" alt="Youtube logo">
                    </a>
                </li>
            </ul>
			<!-- Div para mostrar el mensaje de derechos de autor -->
            <div class="Copy">
                <h3>&copy; Eugenio Jimenez</h3>
            </div>
        </footer>
	</div>
	</body>
</html>