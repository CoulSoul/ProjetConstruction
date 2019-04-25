<?php 
session_start();

	try{
		$bd = new PDO('mysql:host=localhost;dbname=constructions', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch(Exception $e){
		die('ERROR : ' .$e->getMessage());
	}


	if (isset($_GET['id']) AND $_GET['id'] > 0) { 

		$getid = intval($_GET['id']);

		$requser = $bd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
		$requser->execute(array($getid));
		$userinfo = $requser->fetch();

		$requser2 = $bd->prepare('SELECT * FROM utilisateursprofil LEFT JOIN utilisateurs ON utilisateursprofil.id_utilisateur = utilisateurs.id WHERE utilisateursprofil.id_utilisateur = ?');
		$requser2->execute(array($getid));
			

	}
?>


<!DOCTYPE html>
<html>
	<head>
		<title>Page de profil</title>
		<link rel="stylesheet" type="text/css" href="Do_css/profil.css">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">


		<!-- Bootstrap -->
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
		<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body>
		<?php include('Menu.php'); ?>
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="part1">
						<div class="avatat">
								<?php 
									if (!empty($userinfo['images'])) { ?>
										<img src="imagesUp/<?php echo $userinfo['images']; ?>" class="img-circle" width='80%' height="auto"/>
								 <?php } ?>
							
						</div>
						<?php if (isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) { ?>
		
							<div class="btn">
								<a href="insert.php" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> Modifier la photo de profil</a>

								<a href="deconnexion.php" class="btn btn-info"><span class="glyphicon glyphicon-log-out"></span> deconnexion</a>
							</div>

						<?php } ?>

						<table>
							<tbody>
								<tr>
									<td> Nom: <span class="infoUser"><?php echo $userinfo['nom']; ?></span></td>
								</tr>
								<tr>
									<td>prenom: <span class="infoUser"><?php echo $userinfo['prenom']; ?></span></td>
								</tr>
								<tr>
									<td>Contact: <span class="infoUser"><?php echo $userinfo['phone']; ?></span></td>
								</tr>
								<tr>
									<td>Commune: <span class="infoUser"><?php echo $userinfo['adresse']; ?></span></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="col-md-8">
					<div class="part2">					
						<section id="realisations">
								<div class="heading">
									<h2>Projet Réalisés</h2>
									<?php if (isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) { ?>
										
									
										<a href="insertprofil.php" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span></a>

									<?php } ?>
								</div>
								<div class="devider"></div>

								<?php  while ($userinfo2 = $requser2->fetch()) { ?>
										
										<div class="row">
											<div class="col-md-6 col-md-offset-3">
												<div class="photo">
													<div class="projet">		
														<div class="description">
															<h5><?php echo $userinfo2['description']; ?></h5>
														</div>
														<img src="imagesUp/<?php echo $userinfo2['imagesprofil']; ?>">
													</div>
												</div>
											</div>
										</div>
										
								<?php } ?>
								
						</section>
					</div>
				</div>

		</div>

	</body>
</html>