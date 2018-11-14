<?php
	session_start();
    
    if (isset($_SESSION['login']))
        unset($_SESSION['login']);
	if(isset($_SESSION['login_pacientes']))
		unset($_SESSION['login_pacientes']);
    
    header("Location: index.php");
?>
