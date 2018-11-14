<?php
	session_start();
  	
  	include_once("gestionBD.php");
 	include_once("gestionarUsuarios.php");
	
	if (isset($_POST['submit'])){
		$usuario= $_POST['usuario'];
		$pass = $_POST['pass'];

		$conexion = crearConexionBD();
		$num_usuarios = consultarUsuario($conexion,$usuario,$pass);
		cerrarConexionBD($conexion);	
	
		if ($num_usuarios == 0)
			$login = "error";	
		else {
			$_SESSION['login'] = $usuario;
			Header("Location: consulta_medicos.php");
		}	
	}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/estilo.css" />
  <title>Gestión de citas: Login Personal Médico</title>
</head>

<body>

<?php
	include_once("cabecera.php");
?>

<main>
	<?php if (isset($login)) {
		echo "<div class=\"error\">";
		echo "Error en la contraseña o no existe el usuario.";
		echo "</div>";
	}	
	?>
	
	<!-- The HTML login form -->
	<br>
	<h4 id="h4introduce">Introduce tus datos para loguearte en la aplicación:</h4>
	<div id="divformloginmedicos">
	<form id="form_medicos"action="login_medicos.php" method="post">
		<div><label for="usuario">Usuario: </label><input type="text" name="usuario" id="usuario" /></div>
		<div><label for="pass">Contraseña: </label><input type="password" name="pass" id="pass" /></div>
		<input type="submit" name="submit" value="Enviar" />
	</form>
	</div>
		
	
</main>
<?php
	include_once("pie.php");
?>
</body>
</html>

