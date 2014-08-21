<?php
	include('dbconnexion.php');
	if($_SESSION['logged_in'] == true){
		$id =$_SESSION['id'];
		$errors= array();  
		if(isset($_POST['submit']) && count($_POST)>0){		
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$query=$db->prepare('SELECT username, password  FROM membres WHERE id=:id');
				$query->bindValue(':id',$id,PDO::PARAM_INT);
				$query->execute();
				$data=$query->fetch();
				if(md5($_POST['Apassword']) == $data['password'] ){
					if($_POST["password"] == $_POST['username'] ){
						$errors[]= 'ton pseudo ne peut pas être identique au mot de passe';
					} 
					if ((empty($_POST["password"])) || (empty($_POST["confirm"])) || (empty($_POST["Apassword"]))) {
						$errors[]=  'Tous les champs ne sont pas remplis';
					}
					if ($_POST["password"] != $_POST["confirm"]) {
						$errors[]=  'Votre mot de passe et le mot de passe de confirmation ne sont pas identiques';
					}
					if(count($errors)<1){
						$password = md5($_POST['password']);
						$id =$_SESSION['id'];
						$query=$db->prepare('UPDATE membres SET password=? WHERE id=?');
						$query->execute(array($password,$id));
						$ok_msg ="mise à jours de votre mot de passe réussi";			
					}
				}else{
					$errors[]= 'ton ancien mot de passe est invalide';
				}
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
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Modifier votre mot de passe | ClosePlaces</title>
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
			<li><a href="logout.php"><i class="fa fa-sign-out"></i> <span>Déconnexion</span></a></li>
		</ul>
	</nav>
<div id="container">
	<form method="post" action="pass.php" onsubmit="return validateForm();" name="myForm"> 
		<section class="init">
			<h1>Changer de mot de passe</h1>
			<ul class="green">
			<?php
				if (isset($ok_msg)) {
					echo "<li><i class='fa fa-check'> </i> $ok_msg  </li>";
				}
			?>
			</ul>
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
		    <div class="modif" >
		    	<label for="Apassword">Ancien mot de Passe <span class="rouge">*</span></label>
		    	<input type="password" name="Apassword" id="Apassword" placeholder="Votre ancien mot de Passe"/>
		    </div>
			<div class="modif" >
				<label for="password">Nouveau mot de Passe <span class="rouge">*</span></label>
				<input type="password" name="password" id="password" placeholder="Votre Nouveau mot de Passe" />
			</div>
			<div class="modif" >
				<label for="confirm">Confirmer le mot de passe <span class="rouge">*</span></label>
				<input type="password" name="confirm" id="confirm" placeholder="Confirmer votre Nouveau mot de Passe" />
			</div>
		</section>
		<p><b>(<span class="rouge">*</span>) Champ obligatoire</b></p>
		<input type="submit" name="submit" id="submit" class="regsub" value="Valider" />
	</form>
</div>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript">
	//validation form js
	$(function validateForm(){
		$("#submit").click(function(){
			$('.error') .remove();
			var Apassword = document.forms["myForm"]["Apassword"].value; 
			var password = document.forms["myForm"]["password"].value; 
			var confirm = document.forms["myForm"]["confirm"].value;  
			
			var errors = false;

			if(confirm==null || confirm==""){
				errors = true;
				$('input[id=confirm]').after('<span class="error"><i class="fa fa-times"></i> Mot de passe manquant</span>');
			}
			if(password==null || password==""){
				errors = true;
				$('input[id=password]').after('<span class="error"><i class="fa fa-times"></i> Mot de passe manquant</span>');
			}
			if(Apassword==null || Apassword==""){
				errors = true;
				$('input[id=Apassword]').after('<span class="error"><i class="fa fa-times"></i>Mot de passe manquant</span>');
			}
			else if(password != confirm){
				errors = true;
				$('input[id=password]').after('<span class="error"><i class="fa fa-times"></i> Votre mot de passe et le mot de passe de confirmation ne sont pas identiques</span>');
				$('input[id=confirm]').after('<span class="error"><i class="fa fa-times"></i> Votre mot de passe et le mot de passe de confirmation ne sont pas identiques</span>');
			}
			else if(Apassword==username){
				errors = true;
				$('input[id=Apassword]').after('<span class="error"><i class="fa fa-times"></i> Votre mot de passe ne peut pas être identique à votre pseudo</span>');
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