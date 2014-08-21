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

	      

	/* permettre de stocker d'autres choses par après réseaux sociaux, biographie, localisation,avatar?... 
	$profile = $db->query("SELECT * FROM ??? WHERE membre_id ='.$id.'");
	if (!empty($profile)){
		$data=$profile->fetch(PDO::FETCH_ASSOC);
		
	
	}else{

	}*/
if(isset($_SESSION['logged_in'])&&$_SESSION['id']== $id){
$pageOwner = true;
}
}
if( $_GET['action']){
$id=$_GET['id'];
$delete=$db->prepare("DELETE FROM membres WHERE id=$id");
$delete->bindValue(':id',$id,PDO::PARAM_INT);
$delete->execute();
header("Location: supp.php");
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
		
		<header>
			<?php if(isset($pageOwner)): ?>
			<nav>
				<ul>
					<li><a href="editprofile.php">Paramètres</a></li>
					<li><a href="editphoto">Modifier votre photo de profile</a></li>
					<li><a href="?action=supprimer" onclick="return(confirm('Etes-vous sûr de vouloir supprimer votre compte?'));">Supprimer votre compte</a></li>	
					<li><a href="logout.php">Déconnexion</a></li>
					
				</ul>
			</nav>
		<?php endif; ?>
			
		</header>

		<div id="container">
			<?php
			echo'<h1>Profil de '.stripslashes(htmlspecialchars($data['username'])).'</h1>';

       	    echo'<p><strong>Prénom : </strong>'.stripslashes(htmlspecialchars($data['first_name'])).'</p>'; 
       	    echo'<p><strong>Nom : </strong>'.stripslashes(htmlspecialchars($data['last_name'])).'</p>';    
	        echo'<p><strong>Adresse E-Mail : </strong>
	        <a href="mailto:'.stripslashes($data['email']).'">
	        '.stripslashes(htmlspecialchars($data['email'])).'</a><br />';
	       	        
	        echo'<p>Ce membre est inscrit depuis le
	        <strong>'.$data['date'].'</strong><br /><br /></p>';


			?>
			
			
			
		</div>
</body>
</html>

