<?php
	include('dbconnexion.php');
	if($_SESSION['logged_in']!= true){
		//validation form php
		$config = array();
		$config['page_inscrit']= 'inscrit.php';
		// Messages d'erreur
		$config['no_fname']="- Je n'ai pas saisi ton prenom";
		$config['no_lname']="- Je n'ai pas saisi ton nom";
		$config['no_username']= "- Je n'ai pas saisi ton pseudo";
		$config['wrong_username']= "- ton pseudo est déjà pris";
		$config['no_password']="- Je n'ai pas saisi ton mot de passe";
		$config['wrong_password']="- ton pseudo ne peut pas être identique au mot de passe ";
		$config['wrong_email']="- ton email semble être incorrect; réessaye stp.";
		$config['no_email']="- Je n'ai pas saisi ton adresse email";
		$errors= array();
		// définir les variables
		$username = trim(strip_tags($_POST['username']));
		$password = trim(strip_tags($_POST['password']));
		$fname = trim(strip_tags($_POST['fname']));
		$lname = trim(strip_tags($_POST['lname']));
		$email = trim(strip_tags($_POST['username']));
		if(isset($_POST['submit']) && count($_POST)>0){			
			// mettre les variables  zéro
			$fname = $lname = $username = $password = $email = "";		
			
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
			   if (empty($_POST["fname"])) {
			    	$errors[]=  $config['no_fname'];
			   }		   
			   if (empty($_POST["lname"])) {
			     	$errors[]=  $config['no_lname'];
			   } 
			   if(($_POST["password"]) == ($_POST["username"]) ){
			   		$errors[]= $config['wrong_password'];
			   }
			   if (empty($_POST["username"])) {
			     	$errors[]=  $config['no_username'];
			   } 
			   if (empty($_POST["password"])) {
			     	$errors[]=  $config['no_password'];
			   } 
			   if (empty($_POST["email"])) {
			     	$errors[]=  $config['no_email'];
			   } 
			   if(!empty($_POST["email"])){
				   	extract($_POST);
			        $result=$db->query("SELECT id,email FROM membres WHERE email='$email'");
			        $result=$result->fetchAll();
			        if (!empty($result)){
			        	$errors[]=  "tu as déjà un compte avec cette adresse-ci.";	
			        }  
			   }
			   if(!empty($_POST["username"])){
				   	extract($_POST);
			        $result=$db->query("SELECT id,username FROM membres WHERE username='$username'");
			        $result=$result->fetchAll();
			        if (!empty($result)){
			        	$errors[]=  "Nom d'utilisateur déjà pris.";	
			        }  
			   }			   
			   if(count($errors)<1){
			   		//insertion dans db
			   		$date = date("Y-m-d");
			   		$fname =$_POST['fname'];
			   		$lname =$_POST['lname'];
			   		$username =$_POST['username'];
			   		$password =$_POST['password'];
			   		$email=$_POST['email'];
			   		$db->query("INSERT INTO membres(fname, lname, username, password, email,date) VALUES ('$fname', '$lname', '$username','".md5($password)."','$email','$date')");
			   		//envoyer email au nouveau avec ses données d'inscription
			   		$to = $_POST["email"];
			   		$subject = "Merci pour votre inscription et bienvenue!";
			   		$headers = "From: close@places.com\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			   		$vusername = $_POST["username"];
			   		$vpassword= $_POST["password"];
					$message = '<html><body>';
					$message .= '<h2>Bonjour,</h2>';
					$message .= '<h3>vous trouverez vos données ci-dessous<h3>';
					$message .= '<br />';
					$message .= '<h5>vos données</h5>';
					$message .= 'Pseudo:'.$vusername;
					$message .= '<br />';
					$message .= 'Mot de passe :'.$vpassword;
					$message .= '<br />';
					$message .= '<p>Ceci est un message automatique, veuillez ne pas répondre directement à ce message.</p> ';
					$message .= '</body></html>';
					mail($to, $subject, $message, $headers);
					//redirection page merci de votre inscription
					header("Location: ".$config['page_inscrit']);
					exit;
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
	<title>S'inscrire | ClosePlaces</title>
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
			<li><a href="index.php">Accueil</a></li>
		</ul>
	</nav>
	<div id="container">
		<form action="register.php" method="post" onsubmit="return validateForm();" name="myForm">
			<section id="regForm">
				<h1>Formulaire d'inscription</h1>
				<p>Vous avez déjà un compte ? <a href="./login.php">Se connecter</a></p>
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
					<label for="fname">Prénom <span class="rouge">*</span></label>
					<input type="text" name="fname" id="fname" placeholder="votre prénom" value="<?php if(!empty($_POST['fname'])){echo $_POST['fname'];} ?>">
				</div>
				<div class="reg">
					<label for="lname">Nom <span class="rouge">*</span></label>
					<input type="text" name="lname" id="lname" placeholder="votre nom de famille" value="<?php if(!empty($_POST['lname'])){echo $_POST['lname'];} ?>">
				</div>
				<div class="reg">
					<label for="username">Nom d'utilisateur <span class="rouge">*</span></label>
					<input type="text" name="username" id="username" placeholder="votre nom d'utilisateur" value="<?php if(!empty($_POST['username'])){echo $_POST['username'];} ?>">
				</div>
				<div class="reg">
					<label for="password">Mot de passe <span class="rouge">*</span></label>
					<input type="password" name="password" id="password" placeholder="votre mot de passe" >
				</div>
				<div class="reg">
					<label for="email">Adresse email <span class="rouge">*</span></label>
					<input type="email" name="email" id="email" placeholder="exemple@exemple.com" value="<?php if(!empty($_POST['email'])){echo $_POST['email'];} ?>">
				</div>
			</section>
			<p><b>(<span class="rouge">*</span>) Champ obligatoire</b></p>
			<input type="submit" name="submit" class="regsub" id="submit" value="S'inscrire">			
		</form>
	</div>	
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript">
	//validation form js
	$(function validateForm(){
		$("#submit").click(function(){
			$('.error') .remove();
			var fname = document.forms["myForm"]["fname"].value; 
			var lname = document.forms["myForm"]["lname"].value; 
			var username = document.forms["myForm"]["username"].value; 
			var email = document.forms["myForm"]["email"].value; 
			var password = document.forms["myForm"]["password"].value; 
			var atpos = email.indexOf("@");
    		var dotpos = email.lastIndexOf(".");
			var errors = false;

			if(fname==null || fname==""){
				errors = true;
				$('input[id=fname]').after('<span class="error"><i class="fa fa-times"></i> Prénom manquant</span>');
			}
			if(lname==null || lname==""){
				errors = true;
				$('input[id=lname]').after('<span class="error"><i class="fa fa-times"></i> Nom manquant</span>');
			}
			if(username==null || username==""){
				errors = true;
				$('input[id=username]').after('<span class="error"><i class="fa fa-times"></i> Pseudo manquant</span>');
			}
			if(password==null || password==""){
				errors = true;
				$('input[id=password]').after('<span class="error"><i class="fa fa-times"></i> Mot de passe manquant</span>');
			}
			else if(password==username){
				errors = true;
				$('input[id=password]').after('<span class="error"><i class="fa fa-times"></i> Votre mot de passe ne peut pas être identique à votre pseudo</span>');
			}
			if(email==null ||email==""){
				errors = true;
				$('input[id=email]').after('<span class="error"><i class="fa fa-times"></i> Adresse email manquante</span>');
			}
			else if(atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length){
				errors = true;
				$('input[id=email]').after('<span class="error"><i class="fa fa-times"></i> Adresse email pas valide</span>');
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