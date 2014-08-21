<?php
include('dbconnexion.php');
$id = $_GET['id'];
if($_SESSION['logged_in'] == true){	

	$query=$db->prepare('SELECT username, first_name, email, last_name, date FROM membres WHERE id=:id');
	$query->bindValue(':id',$id, PDO::PARAM_INT);
	$query->execute();
	$data=$query->fetch(PDO::FETCH_ASSOC);
	
		
}else{
	header("Location: login.php");
}
if(isset($_SESSION['logged_in']) && $_SESSION['id']== $id){
	$pageOwner = true;

	
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
		
		
		<?php if(isset($pageOwner)): ?>
			<nav>
				<ul>
					
					<li><a href="?id=$id&action=modifier">Modifier votre profile</a></li>
					<li><a href="editphoto">Modifier votre photo de profile</a></li>
					<li><a href="delete.php" onclick="return(confirm('Etes-vous sûr de vouloir supprimer votre compte?'));">Supprimer votre compte</a></li>	
		<?php endif; ?>
					<li><a href="logout.php">Déconnexion</a></li>
					
				</ul>
			</nav>
		
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
</body>
</html>