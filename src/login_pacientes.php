<?php
	session_start();
  	
  	include_once("gestionBD.php");
 	include_once("gestionarUsuarios.php");
	
	if (isset($_POST['submit'])){
		$dni= $_POST['dni'];
		$pass = $_POST['pass'];

		$conexion = crearConexionBD();
		$num_usuarios = consultarPaciente($conexion,$dni,$pass);
		cerrarConexionBD($conexion);	
	
		if ($num_usuarios == 0)
			$login = "error";	
		else {
			$_SESSION['login_pacientes'] = $dni;
			Header("Location: consulta_pacientes.php");
		}	
	}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/estilo.css" />
  <title>Gestión de citas: Login Pacientes</title>
</head>

<body>

<?php
	include_once("cabecera.php");
?>

<main>
	<?php if (isset($login)) {
		echo "<div class=\"error\">";
		echo "Error en la contraseña o no existe el dni en la base de datos.";
		echo "</div>";
	}	
	?>
	
	<!-- The HTML login form -->
	<br>
	<h4 id="h4introduce">Introduce tus datos para loguearte en la aplicación:</h4>
	<div id="divformloginpacientes">
	<form id="form_pacientes"action="login_pacientes.php" method="post">
		<div><label for="dni">DNI/NIF: </label><input type="text" name="dni" id="dni" /></div>
		<div><label for="pass">Contraseña: </label><input type="password" name="pass" id="pass" /></div>
		<input type="submit" name="submit" value="Enviar" />
	</form>
	<p id="registrate">¿No estás registrado? <a href="form_alta_paciente.php">¡Registrate!</a></p>
	</div>
		
	
</main>
<?php
	include_once("pie.php");
?>
</body>
</html>

