<?php
include('dbconnexion.php');
if(isset($_GET['id'])){

		$id = $_GET['id'] = $_SESSION['id'];
	}else{
		echo 'mauvais pseudo ou mot de passe';
		exit();
	}

	$query=$db->prepare('SELECT * FROM membres WHERE id=:id');
		if (empty($query)){
			echo 'mauvais pseudo ou mot de passe';
			exit();
		}else{
			$query->bindValue(':id',$id, PDO::PARAM_INT);
			$query->execute();
			$data=$query->fetch(PDO::FETCH_ASSOC);

			/* permettre de stocker d'autres choses par après réseaux sociaux, biographie, localisation,... 
			$profile = $db->query("SELECT * FROM ??? WHERE membre_id ='.$id.'");
			if (!empty($profile)){
				$data=$profile->fetch(PDO::FETCH_ASSOC);
				
			
			}else{

			}*/
	if(isset($_SESSION['logged_in'])&&$_SESSION['id']== $id){
		$pageOwner = true;
	}
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  
  <meta charset="utf-8">
  <link rel="icon" type="image/png" href="img/favicon.png">
  
  <meta name="viewport" content="width=device-width">

  <title>mon profile</title>
  <link rel="stylesheet" type="text/css" href="css/reset.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  
</head>
<body>
		<a href="logout.php">déconnexion</a>

		<div id="container">
			
			<ul>
				<li><a href="?id=$id&action=consulter">consulter</a></li>
				<li><a href="?id=$id&action=modifier">modifier</a></li>
				<li><a href="?id=$id&action=supprimer" onclick="return(confirm('Etes-vous sûr de vouloir supprimer votre compte?'));">supprimer votre compte</a></li>
				
			</ul>
			
		</div>
</body>
</html>

