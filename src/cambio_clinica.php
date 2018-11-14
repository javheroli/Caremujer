<?php
require_once("gestionBD.php");



// Si llegamos a este script por haber seleccionado una clínica
if(isset($_GET["clinicaMedico"])){
	// Abrimos una conexión con la BD y consultamos la lista de médicos dada una clínica
	$conexion = crearConexionBD();
	$resultado = listarMedicos($conexion, $_GET["clinicaMedico"]);
	
	if($resultado != NULL){
		// Para cada médico del listado devuelto
		foreach($resultado as $medico){
			// Creamos options con valores = usuario_medico 
			echo "<option label='" . $medico["ESPECIALIDAD"] . "' value='" . $medico["USUARIO_MEDICO"] . "'/>";
		}
	}
	// Cerramos la conexión y borramos de la sesión la variable "clínica"
	cerrarConexionBD($conexion);
	unset($_GET["clinicaMedico"]);
}


// Función que devuelve el listado de municipios de una provincia dada
function listarMedicos($conexion, $clinica){
	try {
		$consulta = "SELECT USUARIO_MEDICO,ESPECIALIDAD FROM TRABAJAEN NATURAL JOIN MEDICOS WHERE OID_CLINICA=:clinica AND ESPECIALIDAD='GINECÓLOGO'";
		$stmt=$conexion->prepare($consulta);
		$stmt->bindParam(':clinica',$clinica);	
		$stmt->execute();	

		return $stmt;
	} catch(PDOException $e) {
		return NULL;
    }
}


?>