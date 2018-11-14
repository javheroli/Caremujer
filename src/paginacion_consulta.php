<?php
function consulta_paginada_ocupadas( $conexion, $dia, $usuario,$query_ocupadas, $pag_num_ocupadas, $pag_size_ocupadas )
{
	try {
		$primera = ( $pag_num_ocupadas - 1 ) * $pag_size_ocupadas + 1;
		$ultima  = $pag_num_ocupadas * $pag_size_ocupadas;
		$consulta_paginada = 
			 "SELECT * FROM ( "
				."SELECT ROWNUM RNUM, AUX.* FROM ( $query_ocupadas ) AUX "
				."WHERE ROWNUM <= :ultima"
			.") "
			."WHERE RNUM >= :primera";

		$stmt = $conexion->prepare( $consulta_paginada );
		$stmt->bindParam( ':primera', $primera );
		$stmt->bindParam( ':ultima',  $ultima  );
		$stmt->bindParam(':dia',$dia);
		$stmt->bindParam(':usuario',$usuario);
		$stmt->execute();
		return $stmt;
	}	
	catch ( PDOException $e ) {
		$_SESSION['excepcion'] = $e->GetMessage();
		header("Location: excepcion.php");
	}
} 

function total_consulta_ocupadas( $conexion,$dia,$usuario, $query_ocupadas )
{
	try {
		$stmt=$conexion->prepare('SELECT COUNT(*) AS TOTAL FROM ('.$query_ocupadas.')');
		$stmt->bindParam(':dia',$dia);
		$stmt->bindParam(':usuario',$usuario);
		$stmt->bindParam(':query_ocupadas',$query_ocupadas);
		$stmt->execute();
		$result = $stmt->fetch();
		$total = $result['TOTAL'];
		return  $total;
	}
	catch ( PDOException $e ) {
		$_SESSION['excepcion'] = $e->GetMessage();
		header("Location: excepcion.php");
	}
} 

function total_consulta_disponibles( $conexion,$dia,$usuario, $query_disponibles )
{
	try {
		$stmt=$conexion->prepare('SELECT COUNT(*) AS TOTAL FROM ('.$query_disponibles.')');
		$stmt->bindParam(':dia',$dia);
		$stmt->bindParam(':usuario',$usuario);
		$stmt->bindParam(':query_disponibles',$query_disponibles);
		$stmt->execute();
		$result = $stmt->fetch();
		$total = $result['TOTAL'];
		return  $total;
	}
	catch ( PDOException $e ) {
		$_SESSION['excepcion'] = $e->GetMessage();
		header("Location: excepcion.php");
	}
} 

function consulta_paginada_disponibles( $conexion, $dia, $usuario,$query_disponibles, $pag_num_disponibles, $pag_size_disponibles )
{
	try {
		$primera = ( $pag_num_disponibles - 1 ) * $pag_size_disponibles + 1;
		$ultima  = $pag_num_disponibles * $pag_size_disponibles;
		$consulta_paginada = 
			 "SELECT * FROM ( "
				."SELECT ROWNUM RNUM, AUX.* FROM ( $query_disponibles ) AUX "
				."WHERE ROWNUM <= :ultima"
			.") "
			."WHERE RNUM >= :primera";

		$stmt = $conexion->prepare( $consulta_paginada );
		$stmt->bindParam( ':primera', $primera );
		$stmt->bindParam( ':ultima',  $ultima  );
		$stmt->bindParam(':dia',$dia);
		$stmt->bindParam(':usuario',$usuario);
		$stmt->execute();
		return $stmt;
	}	
	catch ( PDOException $e ) {
		$_SESSION['excepcion'] = $e->GetMessage();
		header("Location: excepcion.php");
	}
} 
?>