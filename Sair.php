<?php

session_start();

//echo $_SESSION['login'];
//if (!(isset($_SESSION['login']) && $_SESSION['login'] = '')) {
	if (isset($_SESSION['login'])) {
	if ($_SESSION['login']!=0) {
	//echo "Pageviews = ". $_SESSION['login']; //retrieve data
	//header ("Location: login3.php");
echo ("Entrou");
session_destroy();

}
}
?>
<html>
<head>
<title>Sair</title>

<style type="text/css">

		body{
			background-color:#f3eaa7;
			background-image: url('Imagens/Logo.jpg');
			background-repeat:no-repeat;
			background-position: center;
			
		}  
 	</style>


</head>
<body>

<br />
<br />
<div id="SAIR" align="center">
<p align="center">
	<?php
		echo("<h1><a href=\"http://localhost:8080/ProjectoACA/login.html\" >Por favor registe-se na pagina inicial<a></h1>");
	?> 
</div>
</p>


</body>
</html>