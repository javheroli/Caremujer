<?php
	session_start();

	require_once("gestionBD.php");
	require_once("gestionarCitas.php");
	
	// SI NO HAY SESIÓN DE USUARIO ABIERTA, REDIRIGIR A LOGIN_PACIENTES.PHP
	// EN OTRO CASO:
	// - HAY QUE CREAR LA CONEXIÓN A LA BASE DE DATOS
	// - INVOCAR LA FUNCIÓN DE CONSULTA DE CITAS DEL PACIENTE
	//		Y GUARDAR EL RESULTADO EN UNA VARIABLE
	// - CERRAR LA CONEXIÓN
	if(isset($_SESSION['login_pacientes'])){
		$conexion =crearConexionBD();
		$dni_paciente = $_SESSION['login_pacientes'];
		$filas = consultarProximasCitas($conexion,$dni_paciente);
		cerrarConexionBD($conexion);
	}else{
		header('Location:login_pacientes.php');
	}
	
	if (isset($_SESSION["errores"])){
		$errores = $_SESSION["errores"];
		unset($_SESSION["errores"]);
	}
	
	
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/estilo.css" />
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
  <script src="js/fecha_hoy.js" type="text/javascript"></script>
  <script src="js/mensaje_confirmacion.js" type="text/javascript"></script>
  <title>Gestión de Citas: Citas de Pacientes</title>
</head>

<body>
	<script>
		$(document).ready(function() {
				$("#clinica").on("input", function () {
				// Llamada AJAX con JQuery, pasándole el valor de la clinica como parámetro
        		$.get("cambio_clinica.php", { clinicaMedico: $('#clinica').val()}, function (data) {
        			// Borro los medicos que hubiera antes en el datalist
        			$("#opcionesMedicos").empty();
        			// Adjunto al datalist la lista de medicos devuelta por la consulta AJAX
        			$("#opcionesMedicos").append(data);
				});
    		})
    		//HORAS DISPONIBLES TRAS ELEGIR UNA FECHA
    		$(document).on('input', '#clinica, #medico, #fecha', function(){
    			const cli = $('#clinica').val();
     			const med = $('#medico').val();
     			const fec = $('#fecha').val();
     			if(cli != '' && med != '' && fec != ''){
        			$.get("cambio_fecha.php", { clinicaHora: $('#clinica').val(), medicoHora: $('#medico').val(), fechaHora: $('#fecha').val()}, function (data) {
        				$("#opcionesHoras").empty();
        				$("#opcionesHoras").append(data);
					});
				}
    		});
    		//OID_CITA TRAS ELEGIR LA CITA COMPLETA
    		$(document).on('input', '#clinica, #medico, #fecha, #hora', function(){
    			const cli = $('#clinica').val();
     			const med = $('#medico').val();
     			const fec = $('#fecha').val();
     			const hor = $('#hora').val();
     			if(cli != '' && med != '' && fec != ''&& hor != ''){
        			$.get("cambio_oid_cita.php", { clinicaOid: $('#clinica').val(), medicoOid: $('#medico').val(), fechaOid: $('#fecha').val(), horaOid: $('#hora').val()}, function (data) {
        				$(".OID_CITA1").attr("value",data);
					});
				}
    		});
		});
	</script>

<?php
	include_once("cabecera.php");
	include_once("menu.php");

?>

<main>
	<div id="divtableproximascitas">
		<h4 id="pedirunacita">Pedir una cita:</h4>
		<h4 id="misproximascitas">Mis próximas Citas:</h4>
		<fieldset id="fieldsetpedircita">
			<form action="controlador_citas.php" id="formpedircita" name="formpedircita">
				<div><label for="clinica">Clínica:</label>
				<input list="opcionesClinicas" name="clinica" id="clinica" required />
				<datalist id="opcionesClinicas">
			  	<?php
			  		$clinicas = listarClinicas($conexion);

			  		foreach($clinicas as $clinica) {
			  			echo "<option label='".$clinica["NOMBRE_CLINICA"]."' value='".$clinica["OID_CLINICA"]."'>";
					}
				?>
				</datalist>
			</div>
			<div><label for="medico">Médico:</label>
			<input id="medico" name="medico"  list="opcionesMedicos" required />
			<datalist id="opcionesMedicos">
			
			</datalist>
			</div>
			<div><label for="fecha">Fecha:</label>
			<input type="date" id="fecha" name="fecha" onclick="fechaActual();" required />
			</div>
			<div><label for="hora">Hora:</label>
			<input id="hora" name="hora"  list="opcionesHoras" required />
			<datalist id="opcionesHoras">
			
			</datalist>
			</div>
			<input type="hidden" id="OID_CITA" name="OID_CITA" class="OID_CITA1" value=""/>
			<div><input onclick="mensajeConfirmacionPedir();"  id="pedircita" name="pedircita" value="PEDIR CITA"/></div>
			</form>
		</fieldset>
		
		
				<table id="tablamisproximascitas">
					<tr>
						<th>HORA:</th>
						<th>FECHA:</th>
						<th>USUARIO MÉDICO:</th>
						<th>CLÍNICA:</th>
						<th>ANULAR:</th>
					</tr>
					<?php	foreach( $filas as $fila ) {
						$conexion =crearConexionBD();
						$nombre_clinicas = consultarDatosClinica($conexion,$fila['OID_CLINICA']);
						cerrarConexionBD($conexion);
					?>
					<form name="formanular" method="get" action="controlador_citas.php">
							<input type="hidden" id="OID_CITA" name="OID_CITA" value="<?php echo $fila["OID_CITA"] ?>"/>

					<tr>
						<td><?php
						echo $fila['HORA'];
						?></td>
						<td><?php
						echo $fila['FECHA'];
						?></td>
						<td><?php
						echo $fila['USUARIO_MEDICO'];
						?></td>
						<td><?php
						foreach( $nombre_clinicas as $nombre_clinica ) {
							echo $nombre_clinica['NOMBRE_CLINICA'];
						}
						?></td>
						<td>
								<button id="anular" name="anular" onclick="mensajeConfirmacionAnular();" class="anular_fila">
									<img src="images/delete_icon.png" class="anular_fila" alt="Anular cita">
								</button></td>
					</tr>
					</form>

					<?php } ?>
				</table>
				
	


	
</main>



</body>
</html>
