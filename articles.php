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
	<meta name="viewport" content="width=device-width">
	<title>Accueil | ClosePlaces</title>
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'>
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
			<li><a href="login.php"><i class="fa fa-user"></i> <span>Mon profil</span></a></li>			
			<li><a href="creer.php?id=<?php echo $id;?>"><i class="fa fa-pencil"></i> <span>Créer un nouvel article</span> </a></li>
			<li><a href="logout.php"><i class="fa fa-sign-out"></i> <span>Déconnexion</span></a></li>
		</ul>
	</nav>

	<section >
		<?php
			$result = $db->query("SELECT * FROM articles ORDER BY RAND() LIMIT 0,1");
			$result = $result->fetchAll();
			echo "<a href='voir.php?id_article=".$result[0]['id_article']."' class='article'><section class='introphoto' style='background:url(members/".$result[0]['id']."/articles/".$result[0]['id_article']."/pcover.jpg)no-repeat center center;-webkit-background-size: cover;
			-moz-background-size: cover;-o-background-size: cover;-ms-background-size: cover;background-size: cover;background-attachment: fixed;'>";
			echo "<h2>".$result[0]['nlieu']."</h2><p class='info'>".$result[0]['vlieu'].", ".$result[0]['plieu']." </p>";
			echo "</section></a>";
		?>
	</section>
	<div class="fluid ">  
      <div class="introicon">
          <a href="tnlieux.php"><div class="iconsintroa borange">
              <h3>Les nouveaux lieux</h3>
          </div></a>
          <a href="tmembres.php"><div class="iconsintroa brouge">
          		<h3>Les  membres</h3>
              
          </div></a>
          <a href="tlieux.php"><div class="iconsintroa bviolet">
              
              <h3>Les lieux</h3>
          </div></a>
          <a href="login.php"><div class="iconsintroa bvert">
              
              <h3>Mes lieux</h3>
          </div></a>
      </div>
  </div>
	
	<div id="nouvlieu" class="grid space">
		<a href="tlieux.php" class='article'>
			<figure class='effect borange  hovero'>
				<figcaption >
					<h2>Les nouveaux lieux</h2>
					<p>voir tous les lieux</p>
				</figcaption>			
			</figure>
		</a>
		<?php    
			$result = $db->query("SELECT * FROM articles ORDER BY  darticle DESC LIMIT 0,5 ");
			$result = $result->fetchAll();
			foreach ($result as $result) {
				extract($result);
				echo "					   	
				<a href='voir.php?id_article=$id_article' class='article'>
				<figure class='effect'>
					<img src='./members/$id/articles/$id_article/pcover.jpg' alt='img01'>
					<figcaption>
						<h2><span>$nlieu</span></h2>
						<p>$vlieu, $plieu</p>
					</figcaption>			
				</figure></a>";
			}
		?>
	</div>
	<div id="memb" class="grid space">
		<a href="tmembres.php" class='article'>
			<figure class='effect brouge  hovero'>
				<figcaption >
					<h2>Les  membres </h2>
					<p>voir tous les membres</p>
				</figcaption>			
			</figure>
		</a>
		<?php    
			$result = $db->query("SELECT id,username, email FROM membres ORDER BY id DESC LIMIT 0,5 ");
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
	<div id="lesl" class="grid space">
		<a href="tlieux.php" class='article'>
			<figure class='effect bviolet hovero'>
				<figcaption >
					<h2>Les Lieux </h2>
					<p>voir tous les lieux</p>
				</figcaption>			
			</figure>
		</a>
		<?php    
			$result = $db->query("SELECT * FROM articles ORDER BY nlieu  LIMIT 0,5 ");
			$result = $result->fetchAll();
			foreach ($result as $result) {
			extract($result);

			echo "					   	
			<a href='voir.php?id_article=$id_article' class='article'>
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
	<div id="mesl" class="grid space" >
		<a href="login.php" class='article'>
			<figure class='effect bvert hovero'>
				<figcaption>
					<h2>Mes lieux</h2>
					<p>Voir toutes mes publications</p>
				</figcaption>			
			</figure>
		</a>
		<?php 
			$id=$_SESSION['id'] ;  
			$result = $db->query("SELECT * FROM articles WHERE id='$id' ORDER BY id DESC  LIMIT 0,5 ");
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