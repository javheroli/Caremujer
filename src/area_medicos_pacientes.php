<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <!-- Hay que indicar el fichero externo de estilos -->
    <link rel="stylesheet" type="text/css" href="css/estilo.css" />
	<script type="text/javascript" src="./js/boton.js"></script>
  <title>CAREMUJER</title>
</head>

<body>

<?php

	include_once("cabecera.php");
	
	include_once("menu.php");


?>
<div class="areatotal">
	<h3>Acceso a la aplicación de Gestión de Citas:</h3>
	<h4 id="h4medicos">Área de personal Médico</h4>
	<h4 id="h4pacientes">Área Pacientes</h4>
	<br><br>
	<a href="consulta_medicos.php"><img id="area-medicos" src="images/area-medicos.jpg" alt="Área Médicos"></a>
	<a href="consulta_pacientes.php"><img id="area-pacientes" src="images/area-pacientes.jpg" alt="Área Pacientes"></a>
</div>
<br>
<?php

	include_once("pie.php");

?>

</body>

</html>