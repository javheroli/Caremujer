<?php
session_start();

// Si no existen datos del formulario en la sesión, se crea una entrada con valores por defecto
if (!isset($_SESSION['formulario'])) {
	$formulario['nif'] = "";
	$formulario['pass'] = "";
	$formulario['nombre'] = "";
	$formulario['apellidos'] = "";
	$formulario['email'] = "";
	$formulario['numeroSeguro'] = "";

	$_SESSION['formulario'] = $formulario;
}
// Si ya existían valores, los cogemos para inicializar el formulario
else
	$formulario = $_SESSION['formulario'];

// Si hay errores de validación, hay que mostrarlos y marcar los campos (El estilo viene dado y ya se explicará)
if (isset($_SESSION["errores"]))
	$errores = $_SESSION["errores"];
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/estilo.css" />
		<script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
		<script src="js/validacion_cliente_alta_paciente.js" type="text/javascript"></script>
		<title>Gestión de Citas: Alta de Pacientes</title>
	</head>

	<body>
		<script>
			// Inicialización de elementos y eventos cuando el documento se carga completamente
			$(document).ready(function() {
				// Manejador de evento del color de la contraseña
				$("#pass").on("keyup", function() {
					// Calculo el color
					passwordColor();
				});
				//Validacion del email
				document.getElementById('email').addEventListener('input', function() {
					campo = event.target;
					valido = document.getElementById('emailOK');

					emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
					//Se muestra un texto a modo de ejemplo, luego va a ser un icono
					if (emailRegex.test(campo.value)) {
						valido.innerText = "válido";
					} else {
						valido.innerText = "incorrecto";
					}
				});
			});
		</script>
		<?php
		include_once ("cabecera.php");
		?>

		<?php
		// Mostrar los erroes de validación (Si los hay)
		if (isset($errores) && count($errores) > 0) {
			echo "<div id=\"div_errores\" class=\"error\">";
			echo "<h4> Errores en el formulario:</h4>";
			foreach ($errores as $error)
				echo $error;
			echo "</div>";
		}
		?>

		<form id="altaPaciente" method="get" action="accion_alta_paciente.php" onsubmit="return validateForm()">
		<p><i>Los campos obligatorios están marcados con </i><em>*</em></p>
		<fieldset><legend>Datos personales</legend>
		<br />
		<div></div><label id="labelfornif" for="nif">NIF<em>*</em></label>
		<input id="nif" name="nif" type="text" placeholder="12345678X" pattern="^[0-9]{8}[A-Z]" title="Ocho dígitos seguidos de una letra mayúscula" value="<?php echo $formulario['nif']; ?>" required>
		</div>
		<div>
			<label for="pass">Password:<em>*</em></label>
			<input type="password" name="pass" id="pass" placeholder="Mínimo 8 caracteres entre letras y dígitos (Debe contener letras mayúsculas y minúsculas)" required oninput="passwordValidation(); "/>
		</div>
		<div>
			<label for="confirmpass">Confirmar Password: </label>
			<input type="password" name="confirmpass" id="confirmpass" placeholder="Confirmación de contraseña" required oninput="passwordConfirmation();"/>
		</div>

		<div>
			<label for="nombre">Nombre:<em>*</em></label>
			<input id="nombre" name="nombre" type="text" size="40" value="<?php echo $formulario['nombre']; ?>" required/>
		</div>

		<div>
			<label for="apellidos">Apellidos:<em>*</em></label>
			<input id="apellidos" name="apellidos" type="text" size="80" value="<?php echo $formulario['apellidos']; ?>"required />
		</div>
		<div>
			<label for="email">Email:<em>*</em></label>
			<input id="email" name="email"  type="email" placeholder="usuario@dominio.extension" value="<?php echo $formulario['email']; ?>" required/>
			<br>
		</div>
		<div>
			<label for="numeroSeguro">Número de Seguro:</label>
			<input id="numeroSeguro" name="numeroSeguro" type="text" size="80" value="<?php echo $formulario['numeroSeguro']; ?>" placeholder="Teclea los 6 dígitos en caso de tener seguro médico"/>
		</div>
		<div>
			<input type="submit" value="Enviar" />
		</div>
		</fieldset>

		</form>

		<?php
		include_once ("pie.php");
		?>

	</body>
</html>
