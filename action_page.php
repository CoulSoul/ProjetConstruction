<?php 
	
	try{
		$bd = new PDO('mysql:host=localhost;dbname=constructions', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch(Exeption $e){
		die("ERROR:" .$e->getMessage());
	}

	if (isset($_POST['envoyer'])) {
		$recherche = htmlspecialchars($_POST['recherche']);

		$requser = $bd->prepare('SELECT * FROM utilisateurs WHERE nom  LIKE ?');
		$requser->execute(array('%$recherche%'));
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>page de traitement</title>
	<meta charset="utf-8">
</head>
<body>
	<?php
		while($row = $requser->fetch()){ ?>

			<table>
				<thead>
					<tr>
						<th>Nom</th>
						<th>Prenom</th>
						<th>Contact</th>
						<th>Adresse</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo $row['nom']; ?></td>
						<td><?php echo $row['prenom']; ?></td>
						<td><?php echo $row['phone']; ?></td>
						<td><?php echo $row['adresse']; ?></td>
					</tr>
				</tbody>
			</table>

	<?php } ?>
	 
</body>
</html>