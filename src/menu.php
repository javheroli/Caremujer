<nav>
	<ul class="topnav" id="myTopnav">
		<li><a href="index.php">Inicio</a></li>
	  	<li><a href="about.php">Sobre nosotros</a></li>
		<li><a href="contacto.php">Contacto</a></li>
		<li><?php if (isset($_SESSION['login'])||isset($_SESSION['login_pacientes'])) {	?>
				<a href="logout.php">Desconectar</a>
			<?php } ?>
		</li>

			<li class="icon">
				<a href="javascript:void(0);" onclick="myToggleMenu()">&#9776;</a>
	</ul>
</nav>
