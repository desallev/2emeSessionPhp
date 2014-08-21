<?php
include('dbconnexion.php');
if($_SESSION['logged_in'] == true){
	$id = $_GET['id'] =$_SESSION['id'];
	$page = $_GET['action'];

	switch ($page){
		case 'supprimer':
			
			$delete=$db->prepare("DELETE FROM membres WHERE id=$id");
			$delete->bindValue(':id',$id,PDO::PARAM_INT);
			$delete->execute();
			header("Location: supp.php");
			
			
		break;
		case 'modifier':
			if (empty($_POST['sent'])){      
		        
		   
		        $query=$db->prepare('SELECT username, first_name, email, last_name, date FROM membres WHERE id=:id');
		        $query->bindValue(':id',$id,PDO::PARAM_INT);
		        $query->execute();
		        $data=$query->fetch();

		        echo '<h1>Modifier son profil</h1>';
        
        		echo '<form method="post" action="profile.php?action=modifier" enctype="multipart/form-data">
       
 
		        <fieldset><legend>Identifiants</legend>
		        Pseudo : <strong>'.stripslashes(htmlspecialchars($data['username'])).'</strong><br />       
		        <label for="password">Nouveau mot de Passe :</label>
		        <input type="password" name="password" id="password" /><br />
		        <label for="confirm">Confirmer le mot de passe :</label>
		        <input type="password" name="confirm" id="confirm"  /><br />
		        <label for="email">Votre adresse E_Mail :</label>
		        <input type="text" name="email" id="email"
		        value="'.stripslashes($data['email']).'" /><br />	
		        </fieldset>
		        <input type="submit" value="Modifier son profil" />	 
		        
		 
		        </form>';
		        $query->CloseCursor();   
    		}else{
        		
    		}
			
			
		break;
		default; 
				$query=$db->prepare('SELECT username, first_name, email, last_name, date FROM membres WHERE id=:id');
				$query->bindValue(':id',$id, PDO::PARAM_INT);
				$query->execute();
				$data=$query->fetch(PDO::FETCH_ASSOC);					
						
				
				if(isset($_SESSION['logged_in'])&&$_SESSION['id']== $id){
					$pageOwner = true;
				}
					
			
			
	}
}else{
	header("Location: login.php");
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
					<li><a href="?action=supprimer" onclick="return(confirm('Etes-vous sûr de vouloir supprimer votre compte?'));">Supprimer votre compte</a></li>	
					<li><a href="logout.php">Déconnexion</a></li>
					
				</ul>
			</nav>
		<?php endif; ?>
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