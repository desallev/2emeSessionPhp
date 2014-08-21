<?php
	include('dbconnexion.php');
	if($_SESSION['logged_in'] == true){
		$id = $_GET["id"];
		$page = $_GET['action'];
		if(isset($_SESSION['logged_in'])&&$_SESSION['id']== $id){
			$pageOwner = true;
		}
		switch ($page){
			case 'supprimer':
				$id =$_SESSION['id'];
				//supression d'articles
				$artdelete=$db->prepare("DELETE FROM articles WHERE id=$id");
				$artdelete->bindValue(':id',$id ,PDO::PARAM_INT);
				$artdelete->execute();
				//creer un dossier user
				if(!is_dir("members/$id")){
					mkdir("members/$id");
				}
				//supression du dossier user
				$dossier = './members/'.$id.'';
				$dir_iterator = new RecursiveDirectoryIterator($dossier);
				$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::CHILD_FIRST);			
				foreach($iterator as $fichier){
					$fichier->isDir() ? rmdir($fichier) : unlink($fichier);
				}
				rmdir($dossier);
				session_destroy();
				unset($_SESSION);
				//supression du user
				$delete=$db->prepare("DELETE FROM membres WHERE id=$id");
				$delete->bindValue(':id',$id,PDO::PARAM_INT);
				$delete->execute();
				header("Location: login.php");
				exit();
			break;
			default;
				$query=$db->prepare('SELECT username, fname, email, lname, date FROM membres WHERE id=:id');
				$query->bindValue(':id',$id, PDO::PARAM_INT);
				$query->execute();
				$data=$query->fetch(PDO::FETCH_ASSOC);
					echo '<div id="container"><section class="photo">';
					echo '<div class="avatarphoto">';
				if(isset($pageOwner)){
					if(file_exists("members/$id/profile_image.jpg")){
						$id=$_SESSION['id'];	
						echo '<abbr title="modifier votre photo de profil"><a href="modifier2.php?id='.$id.'"><img src="./members/'.$id.'/profile_image.jpg" width="170" height="170" /></a></abbr>';
					}else{
						echo'<abbr title="modifier votre photo de profil"><a href="modifier2.php?id='.$id.'"><img src="http://www.gravatar.com/avatar/'.md5($data['email']).'?s=170"/></a></abbr>';
					}
					echo'</div>';	
				}else{
					if(file_exists("members/$id/profile_image.jpg")){
					$id=$_GET['id'];	
					echo '<img src="./members/'.$id.'/profile_image.jpg" width="170" height="170" />';
				}else{
					echo'<img src="http://www.gravatar.com/avatar/'.md5($data['email']).'?s=170"/>';
				}
				echo'</div>';
				}
				echo'<div class="avatartxt ">';
				echo'<h1>Profil de '.stripslashes(htmlspecialchars($data['username'])).'</h1>';
				echo'<p><span>'.stripslashes(htmlspecialchars($data['fname'])).'</span> <span>'.stripslashes(htmlspecialchars($data['lname'])).'</span></p>';    
				echo'<p><a href="mailto:'.stripslashes($data['email']).'"><i class="fa fa-envelope-o"></i>'.stripslashes(htmlspecialchars($data['email'])).'</a></p>';    
				echo'<p>Membre depuis le <strong>'.date("d.m.Y", strtotime($data['date'])).'</strong></p></div></section></div>';
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
	<title>Mon profil | ClosePlaces</title>
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'>
</head>
<body>
	<div class="banderole">
		<div class="elem bbleu"></div>
		<div class="elem bvert"></div>
		<div class="elem bjaune"></div>
		<div class="elem borange"></div>
		<div class="elem brouge"></div>
		<div class="elem bviolet"></div>
		<div class="clear"></div>
	</div>
	<nav id="menu">
		<ul class="menu">
			<li><a href="articles.php">ClosePlaces</a></li>
			<li><a href="articles.php?id=<?php echo $id?>">Accueil</a></li>
				<?php if(isset($pageOwner)): ?>
					<li><a href="modifier.php"><i class="fa fa-wrench"></i> <span>Modifier votre profil</span></a></li>
					<li><a href="pass.php"><i class="fa fa-lock"></i> <span>Modifier votre mot de passe</span> </a></li>
					<li><a href="profile.php?id=<?php echo $id?>&action=supprimer" onclick="return(confirm('Etes-vous sûr de vouloir supprimer votre compte?'));"><i class="fa fa-trash-o"></i> <span>Supprimer votre compte</span></a></li>	
				<?php else:?>
					<li><a href="login.php"><i class="fa fa-user"></i> <span>Mon profil</span></a></li>			
				<?php endif;?>
			<li><a href="logout.php"><i class="fa fa-sign-out"></i> <span>Déconnexion</span></a></li>
		</ul>
	</nav>
	<div class="grid">
		<a href="creer.php?id=<?php echo $id?>" class='article'><figure class='effect bvert hovero'>
			<figcaption>
				<h2>Nouveau lieu ?</h2>
				<p>Publier un nouveau lieu</p>	
			</figcaption>			
			</figure>
		</a>
		<?php    
			$result = $db->query("SELECT * FROM articles WHERE id='$id' ORDER BY id DESC");
			$result = $result->fetchAll();
			foreach ($result as $result) {
				extract($result);	
				echo "	
			   	<a href='voir.php?id=$id&id_article=$id_article' class='article'>
				   	<figure class='effect'>
						<img src='./members/$id/articles/$id_article/pcover.jpg' alt='img01'>
						<figcaption>
							<h2><span>$nlieu</span></h2>
							<p>$vlieu, $plieu</p>			
						</figcaption>			
					</figure>
				</a>";	
			}
		?>				
	</div>
	<footer>
		<p>© ClosePlaces - Tous droits réservés - <a href="credit.php">Crédits</a></p>
	</footer>	
</body>
</html>