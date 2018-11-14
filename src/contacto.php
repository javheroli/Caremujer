<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/estilo.css" />
		<title>Contacto: CAREMUJER</title>
	</head>

	<body>
		<?php
		include_once ("cabecera.php");
		include_once ("menu.php");
		?>
		<main>
		<div class="divtotal">
				<div class="divcl1">
					<h3>CAREMUJER <br/> Clínica La Paz</h3>
					<h4>Avda. Luis Montoto, 81 <br> 41018 Sevilla (España)</h4>
					<h4>Tlfn: 954786925</h4>
					<h4>E-mail: info@caremujer.es</h4>
				</div>
			<div class="divcl2">
				<h3>CAREMUJER <br/> Clínica Santa Isabel</h3>
				<h4>C/Rafael Salgado, 3 <br> 41013 – Sevilla (España)</h4>
				<h4>Tlfn: 954786926</h4>
				<h4>E-mail: info@caremujer.es</h4>
			</div>
		</div>
			
		</main>

		<?php
		include_once ("pie.php");
		?>
	</body>
</html>
