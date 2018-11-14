<?php
require_once("gestionBD.php");



// Si llegamos a este script por haber seleccionado una fecha
if(isset($_GET["clinicaHora"])&&isset($_GET["medicoHora"])&&isset($_GET["fechaHora"])){
	// Abrimos una conexión con la BD y consultamos la lista de horas dada una fecha
	$conexion = crearConexionBD();
	$resultado = listarHoras($conexion, $_GET["fechaHora"],$_GET["medicoHora"],$_GET["clinicaHora"]);
	if($resultado != NULL){
		// Para cada hora del listado devuelto
		foreach($resultado as $hora){
			// Creamos options con valores = hora 
			echo "<option value='" . $hora["HORA"] . "'/>";
		}
	}
	// Cerramos la conexión y borramos de la sesión la variable "fecha"
	cerrarConexionBD($conexion);
	unset($_GET["fechaHora"]);
	unset($_GET["medicoHora"]);
	unset($_GET["clinicaHora"]);
	
}


// Función que devuelve el listado de municipios de una provincia dada
function listarHoras($conexion, $fecha,$medico,$clinica){
	$fecha_formateada=date_format(date_create($fecha), 'd/m/Y');
	try {
		$consulta = "SELECT HORA FROM CITAS WHERE FECHA=:fecha_formateada AND USUARIO_MEDICO=:medico AND OID_CLINICA=:clinica AND DNI_PACIENTE IS NULL";
		$stmt=$conexion->prepare($consulta);
		$stmt->bindParam(':fecha',$fecha);
		$stmt->bindParam(':medico',$medico);
		$stmt->bindParam(':clinica',$clinica);
		$stmt->bindParam(':fecha_formateada',$fecha_formateada);
		$stmt->execute();	

		return $stmt;
	} catch(PDOException $e) {
		return NULL;
    }
}


?>