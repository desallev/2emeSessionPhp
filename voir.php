<?php
	include('dbconnexion.php');
	header('Content-type: text/html; charset=utf-8'); 
	if($_SESSION['logged_in'] == true){
		$id = $_SESSION['id'];
		$id_article = $_GET['id_article'];
		$result = $db->query("SELECT * FROM articles WHERE id_article=$id_article");
		$result = $result->fetchAll();
		$iduser = $result[0]["id"];
		$idarticle = $result[0]["id_article"];
		$pcover = $result[0]["pcover"];
		$date=$result[0]["darticle"];
		$newDate = date("d.m.Y", strtotime($date));
		if($id==$iduser){
			$pageOwner = true;
		}
		$action = $_GET['action'];
		switch ($action){
			case 'supprimer':
				$id_article = $_GET["id_article"];
				if(file_exists("members/$id/articles/$id_article/pcover.jpg")){
					unlink("members/$id/articles/$id_article/pcover.jpg");
				}
				$dossier = 'members/'.$id.'/articles/'.$id_article.'';
				$dir_iterator = new RecursiveDirectoryIterator($dossier);
				$iterator = new RecursiveIteratorIterator($dir_iterator);			
				foreach($iterator as $fichier){
					$fichier->isDir() ? rmdir($fichier) : unlink($fichier);
				}
				rmdir($dossier);
				$delete=$db->prepare("DELETE FROM articles WHERE id_article=$id_article");
				$delete->bindValue(':id_article',$id_article,PDO::PARAM_INT);
				$delete->execute();
				header("Location: login.php");				
			break;
			default;
				echo'
				<abbr title="Cliquer pour voir l \'image dans son intégralité.">
					<a href="./members/'.$iduser.'/articles/'.$id_article.'/pcover.jpg" target="_blank">
						<div class="bg-img" style="  background:url(members/'.$result[0]['id'].'/articles/'.$result[0]['id_article'].'/pcover.jpg) no-repeat center center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;-ms-background-size: cover;background-size: cover;background-attachment: fixed;" ></div>
					</a>
				</abbr>					
				<article class="art">					
					<div id= "titre">		
						<h1>'.$result[0]["nlieu"].' </h1>
						
						<h2 class="subline">'.$result[0]["vlieu"].', '.$result[0]["plieu"].'</h2>

					</div>
					<div class="fondart">
						<div class="centre">
						<p>'.$result[0]["tarticle"].'</p>
					</div></div>
						<h3>publié par  <strong><a href="profile.php?id='.$iduser.'">'.$result[0]["user"].'</a></strong>, le '.$newDate.'</h3>
				</article>';
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
	<title><?php echo $result[0]["nlieu"];?> | ClosePlaces</title>
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
		<?php if(isset($pageOwner)): ?>
			<li><a href="creer.php?id=<?php echo $id;?>"><i class="fa fa-pencil"></i> <span>Créer un nouvelle article</span> </a></li>
			<li><a href="editer.php?id=<?php echo $id;?>&id_article=<?php echo $id_article;?>"><i class="fa fa-pencil-square-o"></i> <span>Editer votre article</span></a></li>
			<li><a href="voir.php?id_article=<?php echo $id_article?>&action=supprimer" onclick="return(confirm('Etes-vous sûr de vouloir supprimer votre article?'));"><i class="fa fa-trash-o"></i> <span>Supprimer votre article</span></a></li>
		<?php else:?>
			<li><a href="creer.php?id=<?php echo $id;?>"><i class="fa fa-pencil"></i> <span>Créer un nouvelle article</span> </a></li>
		<?php endif;?>
		<li><a href="logout.php"><i class="fa fa-sign-out"></i> <span>Déconnexion</span></a></li>
	</ul>
	</nav>
	<footer>
		<p>© ClosePlaces - Tous droits réservés - <a href="credit.php">Crédits</a></p>
	</footer>
</body>
</html>



