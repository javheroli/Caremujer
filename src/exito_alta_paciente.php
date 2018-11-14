<?php
	session_start();

	require_once("gestionBD.php");
	require_once("gestionarUsuarios.php");
		
	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_SESSION["formulario"])) {
		$nuevoUsuario = $_SESSION["formulario"];
		$_SESSION["formulario"] = null;
		$_SESSION["errores"] = null;
	}
	else 
		Header("Location: form_alta_paciente.php");	

	$conexion = crearConexionBD(); 

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/estilo.css" />
  <title>Gestión de Citas: Alta de Paciente realizada con éxito</title>
</head>

<body>
	<?php
		include_once("cabecera.php");
	?>

	<main>
		<?php if (alta_paciente($conexion, $nuevoUsuario)) { 
				$_SESSION['login_pacientes'] = $nuevoUsuario['nif'];
		?>
				<br>
				<h1 id="hexitoregistro">Hola <?php echo $nuevoUsuario["nombre"]; ?>, gracias por registrarte</h1>
				<br>
				<div id="enlaceexito">	
			   		Pulsa <a href="consulta_pacientes.php">AQUÍ</a> para acceder directamente a la gestión de citas.
				</div>
		<?php } else { ?>
				<br>
				<h1 id="hfalloregistro">El NIF introducido ya está registrado en la base de datos.</h1>
				<br />
				<div id="enlacefallo" >	
					Pulsa <a href="login_pacientes.php">AQUÍ</a> para volver directamente a la página de identificación.
				</div>
		<?php } ?>

	</main>

	<?php
		include_once("pie.php");
	?>
</body>
</html>
<?php
	cerrarConexionBD($conexion);
?>

