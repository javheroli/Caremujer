<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión     			 
     * #	de libros de la capa de acceso a datos 		
     * #==========================================================#
     */

function consultarCitasOcupadas($conexion, $dia, $usuario) {
	$stmt=$conexion->prepare('SELECT HORA,DNI_PACIENTE,FECHA FROM CITAS WHERE (FECHA = :dia AND USUARIO_MEDICO=:usuario AND DNI_PACIENTE IS NOT NULL) ORDER BY HORA');
    $stmt->bindParam(':dia',$dia);
	$stmt->bindParam(':usuario',$usuario);
	$stmt->execute();
    return $stmt;
}

function consultarCitasLibres($conexion, $dia, $usuario) {
	$stmt=$conexion->prepare('SELECT HORA,DNI_PACIENTE,FECHA,OID_CITA FROM CITAS WHERE (FECHA = :dia AND USUARIO_MEDICO=:usuario AND DNI_PACIENTE IS  NULL) ORDER BY HORA');
    $stmt->bindParam(':dia',$dia);
	$stmt->bindParam(':usuario',$usuario);
	$stmt->execute();
    return $stmt;
}
function quitar_cita_medico($conexion,$OidCita) {
	try {
		$stmt=$conexion->prepare('DELETE FROM CITAS WHERE OID_CITA=:OidCita');
		$stmt->bindParam(':OidCita',$OidCita);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
function consultarProximasCitas($conexion, $dni_paciente) {
	$stmt=$conexion->prepare('SELECT HORA,FECHA,USUARIO_MEDICO,OID_CLINICA,OID_CITA FROM CITAS WHERE (DNI_PACIENTE=:dni_paciente AND FECHA>=CURRENT_DATE) ORDER BY FECHA,HORA');
    $stmt->bindParam(':dni_paciente',$dni_paciente);
	$stmt->execute();
    return $stmt;
}

function consultarDatosClinica($conexion, $Oid_clinica) {
	$stmt=$conexion->prepare('SELECT NOMBRE_CLINICA,DIRECCION FROM CLINICAS WHERE (OID_CLINICA=:oid_clinica)');
    $stmt->bindParam(':oid_clinica',$Oid_clinica);
	$stmt->execute();
    return $stmt;
}

function anular_cita_paciente($conexion,$OidCita) {
	try {
		$stmt=$conexion->prepare('UPDATE CITAS SET DNI_PACIENTE=NULL WHERE OID_CITA=:oid_cita');
		$stmt->bindParam(':oid_cita',$OidCita);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
function listarClinicas($conexion) {
	$stmt=$conexion->prepare('SELECT NOMBRE_CLINICA,OID_CLINICA FROM CLINICAS');
	$stmt->execute();
    return $stmt;
}
function pedir_cita_paciente($conexion,$OidCita, $dni) {
	try {
		$stmt=$conexion->prepare('UPDATE CITAS SET DNI_PACIENTE=:dni WHERE OID_CITA=:oid_cita');
		$stmt->bindParam(':oid_cita',$OidCita);
		$stmt->bindParam(':dni',$dni);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
    
?>