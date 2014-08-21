<?php
	include('dbconnexion.php');
	$errors= array();
	if($_SESSION['logged_in'] == true){
		$id = $_SESSION['id'];
		$query=$db->prepare('SELECT * FROM membres WHERE id=:id');
		$query->bindValue(':id',$id, PDO::PARAM_INT);
		$query->execute();
		$data=$query->fetch(PDO::FETCH_ASSOC);
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
	<title>Tous nos membres | ClosePlaces</title>
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
			<li><a href="articles.php">Accueil</a></li>
			<li><a href="login.php"><i class="fa fa-user"></i> <span>Mon profil</span></a></li>			
			<li><a href="creer.php?id=<?php echo $id;?>"><i class="fa fa-pencil"></i> <span>Créer un nouvelle article</span> </a></li>
			<li><a href="logout.php"><i class="fa fa-sign-out"></i> <span>Déconnexion</span></a></li>
		</ul>
	</nav>
	<div class="grid space">
		<a href="login.php" class='article'>
			<figure class='effect brouge hovero'>
				<figcaption >
					<h2>Vous ? </h2>
					<p>voir mon profil</p>
				</figcaption>			
			</figure>
		</a>
	<?php    
	$result = $db->query("SELECT id,username, email FROM membres ORDER BY id DESC  ");
		$result = $result->fetchAll();
		foreach ($result as $result) {
			extract($result);
			echo "					   	
			<a href='profile.php?id=$id' class='article'>
				<figure class='effect'>";
					if(file_exists("members/$id/profile_image.jpg")){
						echo '<img src="./members/'.$id.'/profile_image.jpg"  />';
					}else{
						echo'<img src="http://www.gravatar.com/avatar/'.md5($email).'?d=http://vincentdesalle.be/tfe/tfe/img/gravatar.jpg"/>';
					}
					echo "	
						<figcaption>
							<h2><span>$username</span></h2>
							<p>voir sa page de profil</p>
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