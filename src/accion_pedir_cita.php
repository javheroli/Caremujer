<?php	
	session_start();
	
	if (isset($_SESSION["cita"])) {
		$cita = $_SESSION["cita"];
		unset($_SESSION["cita"]);
		
		require_once("gestionBD.php");
		require_once("gestionarCitas.php");
		
		// CREAR LA CONEXIÓN A LA BASE DE DATOS
		// INVOCAR "pedir_cita_paciente"
		// CERRAR LA CONEXIÓN
		$conexion = crearConexionBD();
		$exception = pedir_cita_paciente($conexion,$cita["OID_CITA"],$_SESSION['login_pacientes']);
		cerrarConexionBD($conexion);
		// SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
		// EN OTRO CASO, VOLVER A "CONSULTA_PACIENTES.PHP"
		if($exception!= "" ){
			$_SESSION["excepcion"]=$excepcion ;
			$_SESSION["destino"]= "consulta_pacientes.php";
			header("location:excepcion.php");
		}else{
			header("location:gracias_por_pedir_cita.php");
		}
	}
	else // Se ha tratado de acceder directamente a este PHP 
		Header("Location: consulta_pacientes.php"); 
?>
