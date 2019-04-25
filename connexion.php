<?php 
session_start();

	try{
		$bd = new PDO('mysql:host=localhost;dbname=constructions', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch(Exception $e){
		die('ERROR: ' .$e->getMessage());
	}

	if (isset($_POST['soumettre'])) {
		$mail = htmlspecialchars($_POST['mailconnect']);
		$motdepasse = sha1($_POST['mdpconnect']);


		if (!empty($mail) AND !empty($motdepasse)) {
			$requser = $bd->prepare('SELECT * FROM utilisateurs WHERE email = ? AND motdepasse = ?');
			$requser->execute(array($mail, $motdepasse));
			$userexist = $requser->rowCount();

			if ($userexist == 1) {
				$userinfo = $requser->fetch();

				$_SESSION['id'] = $userinfo['id'];
				$_SESSION['nom'] = $userinfo['nom'];
				$_SESSION['prenom'] = $userinfo['prenom'];
				$_SESSION['email'] = $userinfo['email'];
				header('location: profil.php?id= '.$_SESSION["id"]);
			}
			else{
				$erreur = "Mauvais mail ou mot de passe";
			}
		}
		else{
			$erreur = "Veuillez renseigner tous les champs correctement svp ):";
		}
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Page de connexion</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="Do_css/connexion.css">

		<!-- BOOTSTRAP -->

		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
		<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body>

		<?php if (isset($erreur)) { ?>
			<div class="alert alert-danger">
				<span class="glyphicon glyphicon-warning-sign"></span>
				<?php 
					echo $erreur;
				?>
			</div>
		<?php } ?>


		<div class="container">
			<div class="heading">
				<h2>Connexion</h2>
			</div>
			<div class="devider"></div>

			<form method="post" action="">
				<div class="row">
					
						<div class="form-group">
							<label for="mail1">Mail</label>
							<input type="email" name="mailconnect" class="form-control" placeholder="Tapez votre adresse mail" id="mail1">
						</div>
					
						<div class="form-group">
							<label for="mdp1">Mot de passe</label>
							<input type="password" name="mdpconnect" class="form-control" placeholder="Tapez votre mot de passe" id="mdp1">
						</div>
					
					<div class="col-md-12">
						<div class="form-group">
							<input type="submit" name="soumettre" value="Envoyer" class="btn btn-warning btn-lg">
						</div>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>