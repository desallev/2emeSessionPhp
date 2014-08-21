<?php
	include('dbconnexion.php');
	if(isset($_SESSION['logged_in'])){	
	}else{
	header("Location: login.php");
	}
	if(isset($_GET['id'])){
		$id=$_GET['id']=$_SESSION['id'];
		$query=$db->prepare('SELECT username, fname, email, lname, date FROM membres WHERE id=:id');
		$query->bindValue(':id',$id, PDO::PARAM_INT);
		$query->execute();
		$data=$query->fetch(PDO::FETCH_ASSOC);
	}else{
		header("Location: login.php");
	}
		$query=$db->query("SELECT id FROM membres WHERE id='$id' AND username='$username'");
	if (empty($query)){
		header("Location: login.php");
	}
	if(!is_dir("members/$id")){
		mkdir("members/$id");
	}
	if (isset($_POST['submit']) ) {
		$file_name = $_FILES['new_file']['name'];
		$file_tmp = $_FILES['new_file']['tmp_name'];
		$file_error = $_FILES['new_file']['error'];
		$file_type = $_FILES['new_file']['type_name'];
		if(!preg_match("/.(gif|jpg|png|jpeg)$/i", $file_name)){
			$error_msg="Fichier non valide";
		}elseif($file_error ===1){
			$error_msg="Une erreur s'est produite veuillez réessayer ultérieurement.";
		}else{
			if(file_exists("members/$id/profile_image.jpg")){
				unlink("members/$id/profile_image.jpg");
			}
			$move_image=move_uploaded_file($file_tmp,"members/$id/profile_image.jpg");
			$ok_msg = "Votre photo de profil à été mise à jour.";
		}
	}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'>
	<title>Modifier votre photo  |  ClosePlaces</title>
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
			<li><a href="logout.php"><i class="fa fa-sign-out"></i> <span>Déconnexion</span></a></li>
		</ul>
	</nav>
	<div id="container">	    
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']  ?>" onsubmit="return validateForm();" name="myForm" enctype="multipart/form-data">
			<section class="photo ">
				<h1>Votre Photo de profil</h1>
				<ul class="green">
					<?php
					if (isset($ok_msg)) {
					echo "<li><i class='fa fa-check'> </i> $ok_msg  </li>";
					}
					?>
				</ul>
				<ul class="red">
					<?php
					if (isset($error_msg)) {
					echo "<li><i class='fa fa-times'></i> $error_msg  </li>";
					}
					?>
				</ul>
				<div class="avatarphoto">
				<?php 
					if(!file_exists("members/$id/profile_image.jpg")){
					echo '
							<img src="http://www.gravatar.com/avatar/'.md5($data['email']).'?s=170"/>
						</div>
						<div class="avatartxt">
							<h3>Mettre à jour votre photo du profil</h3>
							<p>Votre photo de profil est lié par défaut à votre compte <a href="https://fr.gravatar.com/">Gravatar</a>.</p>
							<div class="bold">
								<label for="avatar">Choisissez une photo :</label>
								<input type="file" name="new_file">
							</div>
							<input type="submit" name="submit" class="modifpro vert" id="submit" value="Modifier" />				
						</div>';
				} else {
					$id=$_GET['id'];
					if(!isset($_POST['submit'])){
					echo '
							<img src="./members/'.$id.'/profile_image.jpg" width="170" height="170" />
						</div>
						<div class="avatartxt">
							<h3>Mettre à jour votre photo du profil</h3>
							<div class="bold">
								<label for="avatar">Choisissez une photo :</label>
								<input type="file" name="new_file">
							</div>
							<input type="submit" name="submit" class="modifpro vert" id="submit" value="Modifier" />
						</div>';
						}else{
						echo '
							<img src="./members/'.$id.'/profile_image.jpg" width="170" height="170" />
						</div>
						<div class="avatartxt">
							<h3>Mettre à jour votre photo du profil</h3>	
							<div class="bold">
								<label for="avatar">Choisissez une photo :</label>
								<input type="file" name="new_file">
							</div>
							<input type="submit" name="submit" class="modifpro vert" id="submit" value="Modifier" />
						</div>';
					}
				}
				?>
			</section>
		</form>
	</div>
</body>
<html>