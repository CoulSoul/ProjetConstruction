<?php 
	session_start();

	try{
		$bd = new PDO('mysql:host=localhost;dbname=constructions', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch(ExcEeption $e){
		die('ERROR: ' .$e->getMessage());
	}


if (!empty($_POST) AND !empty($_FILES)) {

	$images = htmlspecialchars($_FILES['images']['name']);
	$imagesPath = 'imagesUp/'.basename($images);
	$imagesExtension = pathinfo($imagesPath, PATHINFO_EXTENSION);
	$isSuccess = true;
	$isUploadSuccess = false;

	if (empty($images)) {
		$isSuccess = false;
	}
	else
	{
		$isUploadSuccess = true;
		if ($isUploadSuccess) {
			if (!move_uploaded_file($_FILES['images']['tmp_name'], $imagesPath)) {
				$error = "il y'a eu une erreur lors de upload";
				$isUploadSuccess = false;
			}
		}
	}
	if ($isSuccess && $isUploadSuccess) {
		$reqinsert = $bd->prepare('UPDATE utilisateurs SET images = ? WHERE id = ?');
		$reqinsert->execute(array($images,  $_SESSION['id']));
		header('location: profil.php?id= '.$_SESSION['id']);
	}
	else
	{
		header('location: insert.php');
	}

}




?>

<!DOCTYPE html>
<html>
	<head>
		<title>Upload Image</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="Do_css/insert.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap -->

		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
		<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="heading">
				<h2>Inserer une Image</h2>
			</div>
			<div class="devider"></div>

			<form method="post" action="" enctype="multipart/form-data">
				<div class="form-group">
					<label for="image">Selectionnez une image</label>
					<input type="file" name="images" id="image">
				</div>

				<div class="form-action">
					<button type="submit" class="btn btn-success" name="ajouter"><span class="glyphicon glyphicon-ok"></span> Ajouter</button>
					<a href="profil.php?id=<?php echo $_SESSION['id']; ?>" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
				</div>
			</form>
		</div>
		<?php if (isset($error)) { ?>
				<div class="msg">
					<?php
						echo $error;
					 ?>
				</div>
			<?php } ?>
	</body>
</html>