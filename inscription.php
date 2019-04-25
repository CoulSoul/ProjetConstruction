<?php
session_start();
	try{
		$bd = new PDO('mysql:host=localhost;dbname=constructions', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch(Exception $e){
		die('ERROR: '.$e->getMessage()); 
	}

	$nom = "";
	$prenom ="";
	$email = "";
	$email2 = "";
	$telephone = "";
	$adresse = "";
	$mdp1 = "";
	$mdp2 = "";

	if (isset($_POST['inscrit'])) {
		$nom = htmlspecialchars($_POST['nom']);
		$prenom = htmlspecialchars($_POST['prenom']);
		$email = htmlspecialchars($_POST['mail1']);
		$email2 = htmlspecialchars($_POST['mail2']);
		$mdp1 = sha1($_POST['mdp1']);
		$mdp2 = sha1($_POST['mdp2']);
		$telephone = htmlspecialchars($_POST['phone']);
		$adresse = htmlspecialchars($_POST['adresse']);
		

			if (!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['mail1']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp1']) AND !empty($_POST['mdp2']) AND !empty($_POST['phone']) AND !empty($_POST['adresse']))
			{
				$nomlength = strlen($nom);
				$prenomlength = strlen($prenom);
				if (preg_match("/^[a-zA-Z].+$/", $nom) && $nomlength <= 100) {
					if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
						if ($email == $email2) {
							$reqmail = $bd->prepare('SELECT * FROM utilisateurs WHERE email = ?');
							$reqmail->execute(array($email));
							$mailexist = $reqmail->rowCount();
							if ($mailexist == 0) {
								if ($mdp1 == $mdp2) {
									if (preg_match("/^[0-9]+$/", $telephone)) {
										
									
											$insertion = $bd->prepare('INSERT INTO `utilisateurs`(`nom`, `prenom`, `email`, `motdepasse`, `phone`, `adresse`) VALUES (?,?,?,?,?,?)');
											$insertion->execute(array($nom, $prenom, $email, $mdp1, $telephone, $adresse));
											$succes = "<span class='glyphicon glyphicon-ok'></span> Inscription terminée :)";
											header("location:connexion.php");
									}
									else
										$erreur = "Veuillez entrer un bon numero de téléphone";
								}
								else{
									$erreur = "<span class='glyphicon glyphicon-warning-sign'></span> Vos deux mot de passe ne correspondent pas ";
								}
							}
							else{
								$erreur = "<span class='glyphicon glyphicon-warning-sign'></span> Ce mail existe déja !";
							}
						}
						else{
							$erreur = "<span class='glyphicon glyphicon-warning-sign'></span> Vos deux mails ne correspondent pas";
						}
					}
					else{
						$erreur = "<span class='glyphicon glyphicon-warning-sign'></span> Vous devez entrer un mail correct svp !";
						
					}
				}
				else{
					$erreur = "<span class='glyphicon glyphicon-warning-sign'></span> Les champs doivent être remplir correctement";
				}
			}
			else{
				$erreur =  "<span class='glyphicon glyphicon-warning-sign'></span> Veuillez remplir tous les champs !";
			}
	}


 ?>


<!DOCTYPE html>
<html>
	<head>
		<title>Page d'inscription</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="Do_css/inscription.css">

		<!-- BOOTSTRAP -->

		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
		<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body>
		<?php if (isset($succes)) { ?>
				<div class="alert alert-success">
					<?php 

						echo $succes;

					?>
				</div>
		<?php } ?>

		<?php if (isset($erreur)) { ?>
				<div class="alert alert-danger">
					<?php 

						echo $erreur;

					?>
				</div>
		<?php } ?>

		<div class="container">
			<div class="heading">
				<h2>Inscription</h2>
			</div>
			<div class="devider"></div>

			<form method="POST" action="">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="nom">Nom</label>
							<input type="text" name="nom" class="form-control" placeholder="Tapez votre nom" id="nom" value="<?php echo $nom; ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="prenom">Prenom</label>
							<input type="text" name="prenom" class="form-control" placeholder="Tapez votre prenom" id="prenom" value="<?php echo $prenom; ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="mail1">Mail</label>
							<input type="email" name="mail1" class="form-control" placeholder="Tapez votre adresse mail" id="mail1" value="<?php echo $email; ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="mail2">Confirmez votre mail</label>
							<input type="email" name="mail2" class="form-control" placeholder="Entrez votre email de confirmation" id="mail2" value="<?php echo $email2; ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="mdp1">Mot de passe</label>
							<input type="password" name="mdp1" class="form-control" placeholder="Tapez votre mot de passe" id="mdp1">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="mdp2">Confirmez votre mot de passe</label>
							<input type="password" name="mdp2" class="form-control" placeholder="Entrez votre mot de passe de confirmation" id="mdp2">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="telephone">Téléphone</label>
							<input type="tel" name="phone" class="form-control" placeholder="Entrez votre Numéro de téléphone" id="telephone" value="<?php echo $telephone; ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="adresse">Adresse</label>
							<input type="text" name="adresse" class="form-control" placeholder="Entrez votre adresse" id="adresse" value="<?php echo $adresse; ?>">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<input type="submit" name="inscrit" value="Envoyer" class="btn btn-warning btn-lg">
						</div>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>