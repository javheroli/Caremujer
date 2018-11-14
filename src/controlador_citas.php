<?php	
	session_start();
	
	if (isset($_REQUEST["OID_CITA"])) {
		$cita["OID_CITA"] = $_REQUEST["OID_CITA"];
		
		$_SESSION["cita"] = $cita;
			
		if (isset($_REQUEST["borrar"])) Header("Location: accion_borrar_cita_medico.php"); 
		if (isset($_REQUEST["anular"])) Header("Location: accion_anular_cita_paciente.php"); 
		if (isset($_REQUEST["pedircita"])) Header("Location: accion_pedir_cita.php"); 
		
	}
	else 
		Header("Location: index.php");
	
?>
