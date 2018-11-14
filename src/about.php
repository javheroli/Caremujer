<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/estilo.css" />
		<title>Sobre nosotros: CAREMUJER</title>
	</head>

	<body>
		<?php
		include_once ("cabecera.php");
		include_once ("menu.php");
		?>
		<main>
		<div id="about">
			<h3>¿Qué es CAREMUJER?</h3>
			<div class="intro">
				<p>
					CareMujer es una clínica privada de ginecología ubicada en Sevilla,
					la cual ofrece servicios de ginecología general, seguimiento del embarazo, y fecundación,
					en la cual se especializan, teniendo una de las mejores instalaciones con material innovador.
					También consta de un grupo médico altamente cualificado y de alta experiencia,
					en cada uno de sus respectivos campos médicos.
				</p>
			</div>
			<div class="instalaciones">
				<h4>Instalaciones</h4>
			</div>
			<div class="pinstalaciones">
				<p style="text-align: justify;">
					Nuestra filosofía es ofrecer lo mejor para nuestras pacientes. <strong>CAREMUJER</strong> cuenta actualmente con unas inmejorables instalaciones,
					en todos los aspectos. Contamos con áreas cómodas para la paciente, con los métodos diagnósticos y
					terapéuticos más eficaces y avanzados tanto en ginecología como en embarazo y parto.
					Nuestros laboratorios de <strong>Reproducción Asistida</strong>, permanentemente actualizados, aplican la tecnología punta más adecuada para cada problema en infertilidad.
					Nuestros <strong>equipos de alta precisión</strong>, junto con instalaciones debidamente controladas y actualizadas,
					nos permiten ofrecer las mejores tasas de embarazo en tratamientos de fertilidad.
				</p>
			</div>
			<div class="equipomedico">
				<h4>Equipo Médico</h4>
			</div>
			<div>
				<p style="text-align: justify;">
					El equipo médico de <strong>CAREMUJER</strong>, con amplia formación y
					alta experiencia, permanentemente actualizados en todas las áreas de la <strong>Ginecología,
					Obstetricia y Medicina de la Reproducción</strong>, al servicio de sus pacientes.
					Te atendemos de forma personalizada en todas nuestras unidades especializadas.
				</p>
			</div>
			<br>
			<div class="imageninstalaciones">
				<img src="images/mesa.jpg" alt="Instalaciones">
			</div>
			</div>

		</main>

		<?php
		include_once ("pie.php");
		?>
	</body>
</html>
