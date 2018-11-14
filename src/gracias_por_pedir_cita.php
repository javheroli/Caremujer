<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta http-equiv="Refresh" content="5;url=/IISSI/Trabajo2CJHO/consulta_pacientes.php">
  <!-- Hay que indicar el fichero externo de estilos -->
    <link rel="stylesheet" type="text/css" href="css/estilo.css" />
	<script type="text/javascript" src="./js/boton.js"></script>
  <title>¡GRACIAS!</title>
</head>

<body>

<?php

	include_once("cabecera.php");
	
	include_once("menu.php");


?>
<br ><br>
<h1 id="grache">¡GRACIAS POR CONFIAR EN CAREMUJER!</h1>
<p id="automaticamente">Volverá al Área Pacientes en 5 segundos</p>
<p id="pincha">O puede pinchar <a href="consulta_pacientes.php">AQUÍ</a> para ir directamente.</p>
<?php

	include_once("pie.php");

?>

</body>

</html>