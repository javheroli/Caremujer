<?php	
	session_start();
	if (isset($_SESSION['dia'])) {
		$dia = $_SESSION['dia'];
		unset($_SESSION["dia"]);	
	}	
	
	if (isset($_SESSION["cita"])) {
		$cita = $_SESSION["cita"];
		unset($_SESSION["cita"]);
		
		require_once("gestionBD.php");
		require_once("gestionarCitas.php");
		
		// CREAR LA CONEXIÓN A LA BASE DE DATOS
		// INVOCAR "quitar_cita_medico"
		// CERRAR LA CONEXIÓN
		$conexion = crearConexionBD();
		$exception = quitar_cita_medico($conexion,$cita["OID_CITA"]);
		cerrarConexionBD($conexion);
		// SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
		// EN OTRO CASO, VOLVER A "CONSULTA_MEDICOS.PHP"
		if($exception!= "" ){
			$_SESSION["excepcion"]=$excepcion ;
			$_SESSION["destino"]= "consulta_medicos.php";
			header("location:excepcion.php");
		}else{
			header("location:consulta_medicos.php?dia=".$dia."&submitdia=BUSCAR");
		}
	}
	else // Se ha tratado de acceder directamente a este PHP 
		Header("Location: consulta_medicos.php"); 
?>
