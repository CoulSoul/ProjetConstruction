<?php 

		try{
			$bd = new PDO('mysql:host=localhost;dbname=constructions', 'root','', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		catch(Excerption $e){
			die('ERROR:' .$e->getMessage());
		}
		$requser = $bd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
		$requser->execute(array($getid));
		$userinfo = $requser->fetch();

?>


<!DOCTYPE html>
<html>
	<head>
		<title>Construction</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="Do_css/style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap -->
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

	</head>
	<body>

			<!-- <header>
				
			</header> -->



		<section id="main">	

			<!-- Navbar --> 

			<div class="container">
				<nav class="navbar navbar-default">
				  <div class="container-fluid">
				    <div class="navbar-header">
				      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span> 
				      </button>
				      <a class="navbar-brand" href="#">ConstuitPro</a>
				    </div>
				    <div class="collapse navbar-collapse" id="myNavbar">
				      <ul class="nav navbar-nav">
				        <li><a href="index.php">Accueil</a></li>
				      </ul>
				      <?php 
				      	if (isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) { ?>

				      		<ul class="nav navbar-nav navbar-right"> 
				       		 <li><a href="deconnexion.php"><span class="glyphicon glyphicon-log-out"></span>Deconnexion</a></li>			      
				    	   </ul>
				      		
				     <?php } ?>

				    </div>
				  </div>
				</nav>

			</div>

	</body>
</html>
