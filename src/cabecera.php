<header>
	<div id="franjaazul">
		<i class="fa fa-phone-square" style="font-size:24px"></i>
		<p id="p1">Tlfn: 954786925</p>
		<p id="p2">E-mail: info@caremujer.es</p>
		<a id="afacebook" href="https://www.facebook.com/pages/CARE-Cl%C3%ADnica-Ginecol%C3%B3gica-Sevilla/136971740796?sk=timeline" class="icon">
			<img id="facebookheader" src="images/facebook-logo.png" alt="Facebook"/>	
		</a>
		<a href="https://twitter.com/caremujer" class="icon"> <img id="twitterheader" src="images/twitter-logo.png" alt="Twitter"></a>
	</div>
	<div>
		
<?php if(isset($_SESSION['login'])){ ?>
		<div id="conectadomedico" >Conectado en el Área Médico como:
			<?php echo "<br>" . $_SESSION['login']?></div>
<?php } ?>
		
<?php if(isset($_SESSION['login_pacientes'])){ ?>
		<div id="conectadopaciente">Conectado en el Área Paciente como: <?php echo "<br>" .$_SESSION['login_pacientes']?></div>
<?php } ?>
		<div id="divlogo"><img id="logo" src="images/encabezado-caremujer.png" alt="CAREMUJER"></div>
	</div>
	
	<h4>Gestión de citas de CAREMUJER</h4>
</header>
