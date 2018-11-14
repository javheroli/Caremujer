<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión
     * #	de usuarios de la capa de acceso a datos
     * #==========================================================#
     */

  
function consultarUsuario($conexion,$usuario,$pass) {
 	$consulta = "SELECT COUNT(*) AS TOTAL FROM MEDICOS WHERE USUARIO_MEDICO=:usuario AND CONTRASEÑA=:pass";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':usuario',$usuario);
	$stmt->bindParam(':pass',$pass);
	$stmt->execute();
	return $stmt->fetchColumn();
}

function consultarPaciente($conexion,$dni,$pass) {
 	$consulta = "SELECT COUNT(*) AS TOTAL FROM PACIENTES WHERE DNI=:dni AND CONTRASEÑA=:pass";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':dni',$dni);
	$stmt->bindParam(':pass',$pass);
	$stmt->execute();
	return $stmt->fetchColumn();
}

function alta_paciente($conexion,$paciente) {
	$null = NULL;

	try {
		$consulta = "INSERT INTO PACIENTES (DNI,CONTRASEÑA, NOMBRE, APELLIDOS, EMAIL, NUMEROSEGURO) VALUES (:nif,:pass,:nombre,:apellidos,:email,:numeroSeguro)";
		$stmt=$conexion->prepare($consulta);
		$stmt->bindParam(':nif',$paciente["nif"]);
		$stmt->bindParam(':nombre',$paciente["nombre"]);
		$stmt->bindParam(':apellidos',$paciente["apellidos"]);
		$stmt->bindParam(':email',$paciente["email"]);
		$stmt->bindParam(':pass',$paciente["pass"]);
		if($paciente["numeroSeguro"]==''){
			$stmt->bindParam(':numeroSeguro',$null);
		}else{
			$stmt->bindParam(':numeroSeguro',$usuario["numeroSeguro"]);
		}
		
		$stmt->execute();
		
		return true;
	} catch(PDOException $e) {
		return false;
		// Si queremos visualizar la excepción durante la depuración: $e->getMessage();
    }
}
