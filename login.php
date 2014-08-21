<?php
	include('dbconnexion.php');
	if($_SESSION['logged_in']!= true){
		//validation form php
		$errors= array();
		if(isset($_POST['submit']) && count($_POST)>0){
			$username = trim(strip_tags($_POST['username']));
			$password = trim(strip_tags($_POST['password']));
			if ((empty($_POST["username"])) || (empty($_POST["password"]))) {
				$errors[]=  $config['no_valid'];
			}
			if(count($errors)<1){
				extract($_POST);
				$result=$db->query("SELECT id, username, password FROM membres WHERE username='$username' and  password='".md5($password)."'");
				$result=$result->fetchColumn(); 
				if (!empty($result)){
					$_SESSION['id'] = $result;
					$id=$_SESSION['id'];
					$_SESSION['logged_in'] = true;
					header("Location: profile.php?id=$id");
					exit();
				}else{
					$errors[]=  'Mauvais identifiant ou mot de passe !';
				}
			}
		}
	}else{
		$id=$_SESSION['id'];
		header("Location: profile.php?id=$id");
		exit();
	}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'>
	<title>Se connecter | ClosePlaces</title>
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
			<li><a href="index.php">ClosePlaces</a></li>
			<li><a href="index.php"> Accueil</a></li>
		</ul>
	</nav>
	<div id="container">
		<form action="login.php" method="post" onsubmit="return validateForm();" name="myForm">
			<section id="regForm">
				<h1>Connexion</h1>
				<p>Vous n'avez pas de compte ? <a href="./register.php">S'inscrire</a></p>
				<p>Si vous avez oublié vos identifiants, cliquer <a href="./email.php">ici</a>.</p>
				<?php
					
					if($_POST && count($errors)>0){
				?>
					<ul class="red">
						<?php
							foreach($errors as $e){ 
								echo "<li><i class='fa fa-times'></i> $e</li>";
							}
						?>
					</ul>
				<?php
					}
				?>
				<div class="reg">
					<label for="username">Nom d'utilisateur <span class="rouge">*</span></label>
					<input type="text" name="username" id="username" placeholder="votre nom d'utilisateur">
				</div>
				<div class="reg">
					<label for="password">Mot de passe <span class="rouge">*</span></label>
					<input type="password" name="password" id="password" placeholder="votre mot de passe" >
				</div>
			</section>
			<p><b>(<span class="rouge">*</span>) Champ obligatoire</b></p>
			<input type="submit" name="submit" class="regsub" id="submit" value="Se connecter">
		</form>	
	</div>
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript">
		//validation form js
		$(function validateForm(){
			$("#submit").click(function(){
				$('.error') .remove();
				var username = document.forms["myForm"]["username"].value; 
				var password = document.forms["myForm"]["password"].value; 
				var errors = false;

				if(username==null || username==""){
					errors = true;
					$('input[id=username]').after('<span class="error"><i class="fa fa-times"></i> Pseudo manquant</span>');
				}
				if(password==null || password==""){
					errors = true;
					$('input[id=password]').after('<span class="error"><i class="fa fa-times"></i> Mot de passe manquant</span>');
				}
				if(errors==false){
					return true;
				}
				return false;
			});
		});
	</script>
	<footer>
		<p>© ClosePlaces - Tous droits réservés - <a href="credit.php">Crédits</a></p>
	</footer>
</body>
<html>