<?php
	// include('action_page.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Liste des differents utilisateurs</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="Do_css/list.css">

		<!-- Bootstrap -->

		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
		<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body>
		
		<table>
			<tr>
			<form class="recherche" action="action_page.php">
			  <div class="input-group">
			    <input type="text" name="recherche" class="form-control" placeholder="Search">
			    <div class="input-group-btn">
			      <button class="btn btn-default" name="envoyer" type="submit">
			        <span class="glyphicon glyphicon-search"></span>
			      </button>
			  </div>
			</form>
			</tr>
			<thead>
				<tr>
					<th>Nom</th>
					<th>Prenom</th>
					<th>Adresse</th>
					<th>Numero de téléphone</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					session_start();

						try{
							$bd = new PDO("mysql:host=localhost;dbname=constructions", "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
						}
						catch(Excepton $e){
							die('ERROR : '.$e->getMessage());
						}

						$requser = $bd->query('SELECT * FROM utilisateurs');
						$userinfo = $requser->fetch();

						


					while($row = $requser->fetch()) { ?>
							 <tr>
								<td><?php echo $row['nom']; ?></td>
								<td><?php echo $row['prenom']; ?></td>
								<td><?php echo $row['adresse']; ?></td>
								<td><?php echo $row['phone']; ?></td>
								<td><a href="profil.php?id=<?php echo $row['id']; ?> ">Voir le Profil</a></td>
							</tr>


					<?php } ?>
				
				
			</tbody>
		</table>
	</body>
</html>