<?php
require_once("gestionBD.php");



// Si llegamos a este script por haber seleccionado una fecha
if(isset($_GET["clinicaOid"])&&isset($_GET["medicoOid"])&&isset($_GET["fechaOid"])&&isset($_GET["horaOid"])){
	// Abrimos una conexión con la BD y consultamos la lista de horas dada una fecha
	$conexion = crearConexionBD();
	$resultado = listarHoras($conexion, $_GET["clinicaOid"],$_GET["medicoOid"],$_GET["fechaOid"],$_GET["horaOid"]);
	if($resultado != NULL){
		// Para cada hora del listado devuelto
		foreach($resultado as $oid){
			// Creamos options con valores = hora 
			echo $oid['OID_CITA'];
		}
	}
	// Cerramos la conexión y borramos de la sesión la variable "fecha"
	cerrarConexionBD($conexion);
	unset($_GET["fechaOid"]);
	unset($_GET["medicoOid"]);
	unset($_GET["clinicaOid"]);
	unset($_GET["horaOid"]);
}


// Función que devuelve el listado de municipios de una provincia dada
function listarHoras($conexion, $clinica, $medico, $fecha,$hora){
	$fecha_formateada=date_format(date_create($fecha), 'd/m/Y');
	try {
		$consulta = "SELECT OID_CITA FROM CITAS WHERE FECHA=:fecha_formateada AND USUARIO_MEDICO=:medico AND OID_CLINICA=:clinica AND HORA=:hora";
		$stmt=$conexion->prepare($consulta);
		$stmt->bindParam(':fecha',$fecha);
		$stmt->bindParam(':medico',$medico);
		$stmt->bindParam(':clinica',$clinica);
		$stmt->bindParam(':hora',$hora);
		$stmt->bindParam(':fecha_formateada',$fecha_formateada);
		$stmt->execute();	

		return $stmt;
	} catch(PDOException $e) {
		return NULL;
    }
}


?>