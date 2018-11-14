<?php
session_start();

require_once ("gestionBD.php");
require_once ("gestionarCitas.php");
require_once ("paginacion_consulta.php");

// SI NO HAY SESIÓN DE USUARIO ABIERTA, REDIRIGIR A LOGIN_MEDICOS.PHP
// EN OTRO CASO:
// - HAY QUE CREAR LA CONEXIÓN A LA BASE DE DATOS
// - INVOCAR LA FUNCIÓN DE CONSULTA DE CONSULTA DE OCUPADAS Y DISPONIBLES DEL MÉDICO SI LE LLEGA POR PARÁMETRO EN LA URL "DIA"
//		Y GUARDAR EL RESULTADO EN UNA VARIABLE
// - CERRAR LA CONEXIÓN
if (isset($_SESSION['login'])) {
	if (isset($_REQUEST['dia'])) {
		$conexion = crearConexionBD();
		$_SESSION['dia'] = $_REQUEST['dia'];
		$dia = date_format(date_create($_REQUEST['dia']), 'd/m/Y');
		$usuario = $_SESSION['login'];
		//EMPIEZA PAGINACIÓN CITAS OCUPADAS
		if (isset($_SESSION["paginacion_ocupadas"])) 
			$paginacion_ocupadas = $_SESSION["paginacion_ocupadas"];

		$pagina_seleccionada_ocupadas = isset($_GET["PAG_NUM_ocupadas"]) ? (int)$_GET["PAG_NUM_ocupadas"] : (isset($paginacion_ocupadas) ? (int)$paginacion_ocupadas["PAG_NUM_ocupadas"] : 1);
		$pag_tam_ocupadas = isset($_GET["PAG_TAM_ocupadas"]) ? (int)$_GET["PAG_TAM_ocupadas"] : (isset($paginacion_ocupadas) ? (int)$paginacion_ocupadas["PAG_TAM_ocupadas"] : 5);

		if ($pagina_seleccionada_ocupadas < 1)
			$pagina_seleccionada_ocupadas = 1;
		if ($pag_tam_ocupadas < 1)
			$pag_tam_ocupadas = 5;

		// Antes de seguir, borramos las variables de sección para no confundirnos más adelante
		unset($_SESSION["paginacion_ocupadas"]);

		// La consulta que ha de paginarse
		$query_ocupadas = 'SELECT HORA,DNI_PACIENTE,FECHA FROM CITAS WHERE (FECHA = :dia AND USUARIO_MEDICO=:usuario AND DNI_PACIENTE IS NOT NULL) ORDER BY HORA';
		// Se comprueba que el tamaño de página, página seleccionada y total de registros son conformes.
		// En caso de que no, se asume el tamaño de página propuesto, pero desde la página 1
		$total_registros_ocupadas = total_consulta_ocupadas($conexion, $dia, $usuario, $query_ocupadas);
		$total_paginas_ocupadas = (int)($total_registros_ocupadas / $pag_tam_ocupadas);
		if ($total_registros_ocupadas % $pag_tam_ocupadas > 0)
			$total_paginas_ocupadas++;

		if ($pagina_seleccionada_ocupadas > $total_paginas_ocupadas)
			$pagina_seleccionada_ocupadas = $total_paginas_ocupadas;

		// Generamos los valores de sesión para página e intervalo para volver a ella después de una operación
		$paginacion_ocupadas["PAG_NUM_ocupadas"] = $pagina_seleccionada_ocupadas;
		$paginacion_ocupadas["PAG_TAM_ocupadas"] = $pag_tam_ocupadas;
		$_SESSION["paginacion_ocupadas"] = $paginacion_ocupadas;

		$filas = consulta_paginada_ocupadas($conexion, $dia, $usuario, $query_ocupadas, $pagina_seleccionada_ocupadas, $pag_tam_ocupadas);


		//EMPIEZA PAGINACIÓN CITAS DISPONIBLES
		if (isset($_SESSION["paginacion_disponibles"])) 
			$paginacion_disponibles = $_SESSION["paginacion_disponibles"];

		$pagina_seleccionada_disponibles = isset($_GET["PAG_NUM_disponibles"]) ? (int)$_GET["PAG_NUM_disponibles"] : (isset($paginacion_disponibles) ? (int)$paginacion_disponibles["PAG_NUM_disponibles"] : 1);
		$pag_tam_disponibles = isset($_GET["PAG_TAM_disponibles"]) ? (int)$_GET["PAG_TAM_disponibles"] : (isset($paginacion_disponibles) ? (int)$paginacion_disponibles["PAG_TAM_disponibles"] : 5);

		if ($pagina_seleccionada_disponibles < 1)
			$pagina_seleccionada_disponibles = 1;
		if ($pag_tam_disponibles < 1)
			$pag_tam_disponibles = 5;

		// Antes de seguir, borramos las variables de sección para no confundirnos más adelante
		unset($_SESSION["paginacion_disponibles"]);

		// La consulta que ha de paginarse
		$query_disponibles = 'SELECT HORA,DNI_PACIENTE,FECHA,OID_CITA FROM CITAS WHERE (FECHA = :dia AND USUARIO_MEDICO=:usuario AND DNI_PACIENTE IS NULL) ORDER BY HORA';
		// Se comprueba que el tamaño de página, página seleccionada y total de registros son conformes.
		// En caso de que no, se asume el tamaño de página propuesto, pero desde la página 1
		$total_registros_disponibles = total_consulta_disponibles($conexion, $dia, $usuario, $query_disponibles);
		$total_paginas_disponibles = (int)($total_registros_disponibles / $pag_tam_disponibles);
		if ($total_registros_disponibles % $pag_tam_disponibles > 0)
			$total_paginas_disponibles++;

		if ($pagina_seleccionada_disponibles > $total_paginas_disponibles)
			$pagina_seleccionada_disponibles = $total_paginas_disponibles;

		// Generamos los valores de sesión para página e intervalo para volver a ella después de una operación
		$paginacion_disponibles["PAG_NUM_disponibles"] = $pagina_seleccionada_disponibles;
		$paginacion_disponibles["PAG_TAM_disponibles"] = $pag_tam_disponibles;
		$_SESSION["paginacion_disponibles"] = $paginacion_disponibles;

		$filas2 = consulta_paginada_disponibles($conexion, $dia, $usuario, $query_disponibles, $pagina_seleccionada_disponibles, $pag_tam_disponibles);
		
		cerrarConexionBD($conexion);
		

	}

} else {
	header('Location:login_medicos.php');
}
?>


<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/estilo.css" />
		<script src="js/mensaje_confirmacion.js" type="text/javascript"></script>
		<title>Gestión de Citas: Citas de Médico</title>
	</head>

	<body>

		<?php
		include_once ("cabecera.php");

		include_once ("menu.php");
		?>

		<main>
			<div id="selecciondiamedicos">
				<h4>Selecciona un día para ver sus Citas ocupadas y libres del mismo:</h4>
				<form id="formdia"action="consulta_medicos.php" method="get">
					<input type="date" id="dia" name="dia" />
					<input type="submit" id="submitdia" name="submitdia" value="BUSCAR"/>
				</form>
			</div>
			<nav id="navpaginacionocupadas">
<?php if(isset($_REQUEST['dia'])){ ?>
		<div id="enlaces">

			<?php

				for( $pagina_ocupadas = 1; $pagina_ocupadas <= $total_paginas_ocupadas; $pagina_ocupadas++ )

					if ( $pagina_ocupadas == $pagina_seleccionada_ocupadas) { 	?>

						<span class="current"><?php echo $pagina_ocupadas; ?></span>

			<?php }	else { ?>

						<a href="consulta_medicos.php?dia=<?php echo $_SESSION['dia']?>&PAG_NUM_ocupadas=<?php echo $pagina_ocupadas; ?>&PAG_TAM_ocupadas=<?php echo $pag_tam_ocupadas; ?>"><?php echo $pagina_ocupadas; ?></a>

			<?php } ?>

		</div>
		<form method="get" action="consulta_medicos.php">
			<input id='dia'type="hidden" name="dia" value="<?php echo $_SESSION['dia']?>"/>

			<input id="PAG_NUM_ocupadas" name="PAG_NUM_ocupadas" type="hidden" value="<?php echo $pagina_seleccionada_ocupadas?>"/>

			Mostrando

			<input id="PAG_TAM_ocupadas" name="PAG_TAM_ocupadas" type="number"

				min="1" max="<?php echo $total_registros_ocupadas; ?>"

				value="<?php echo $pag_tam_ocupadas?>" autofocus="autofocus" />

			entradas de <?php echo $total_registros_ocupadas?>

			<input type="submit" value="Cambiar">

		</form>

	</nav>
<?php } ?>

<nav id="navpaginaciondisponibles">
<?php if(isset($_REQUEST['dia'])){ ?>
		<div id="enlacesdisponibles">

			<?php

				for( $pagina_disponibles = 1; $pagina_disponibles <= $total_paginas_disponibles; $pagina_disponibles++ )

					if ( $pagina_disponibles == $pagina_seleccionada_disponibles) { 	?>

						<span class="current2"><?php echo $pagina_disponibles; ?></span>

			<?php }	else { ?>

						<a href="consulta_medicos.php?dia=<?php echo $_SESSION['dia']?>&PAG_NUM_disponibles=<?php echo $pagina_disponibles; ?>&PAG_TAM_disponibles=<?php echo $pag_tam_disponibles; ?>"><?php echo $pagina_disponibles; ?></a>

			<?php } ?>

		</div>
		<form method="get" action="consulta_medicos.php">
			<input id='dia'type="hidden" name="dia" value="<?php echo $_SESSION['dia']?>"/>

			<input id="PAG_NUM_disponibles" name="PAG_NUM_disponibles" type="hidden" value="<?php echo $pagina_seleccionada_disponibles?>"/>

			Mostrando

			<input id="PAG_TAM_disponibles" name="PAG_TAM_disponibles" type="number"

				min="1" max="<?php echo $total_registros_disponibles; ?>"

				value="<?php echo $pag_tam_disponibles?>" autofocus="autofocus" />

			entradas de <?php echo $total_registros_disponibles?>

			<input type="submit" value="Cambiar">

		</form>

	</nav>
<?php } ?>

			<?php
if(isset($filas)){
			?>
			<h4 id="citasocupadas">Citas Ocupadas:</h4>
			<h4 id="citasolibres">Citas Libres:</h4>
			<div id="divtablemedicos">
				<table id="tablacitasocupadas">
					<tr>
						<th>HORA:</th>
						<th>DNI_PACIENTE:</th>
						<th>FECHA:</th>
					</tr>
					<?php	foreach( $filas as $fila ) {

					?>

					<tr>
						<td><?php
						echo $fila['HORA'];
						?></td>
						<td><?php
						echo $fila['DNI_PACIENTE'];
						?></td>
						<td><?php
						echo $fila['FECHA'];
						?></td>
					</tr>

					<?php }
	}
					?>
				</table>

				<?php
if(isset($filas2)){
				?>
				<table id="tablacitaslibres">
					<tr>
						<th>HORA:</th>
						<th>DNI_PACIENTE:</th>
						<th>FECHA:</th>
						<th>ELIMINAR:</th>
					</tr>
					<?php	foreach( $filas2 as $fila2 ) {

					?>
						<form name="formborrar" method="get" action="controlador_citas.php">
							<input type="hidden" id="OID_CITA" name="OID_CITA" value="<?php echo $fila2['OID_CITA'] ?>"/>

							<tr>
								<td><?php
								echo $fila2['HORA'];
								?></td>
								<td><?php
								echo "LIBRE";
								?></td>
								<td><?php
								echo $fila2['FECHA'];
								?></td>
								<td>
								<button id="borrar" name="borrar"  class="borrar_fila" onclick="mensajeConfirmacionBorrar();">
									<img src="images/delete_icon.png" class="borrar_fila" alt="Borrar cita">
								</button></td>
							</tr>
						</form>
						<?php }
							}
						?>
						
				</table>
			</div>
		</main>

		<?php
		include_once ("pie.php");
		?>
	</body>
</html>
