<?php
include('dbconnexion.php');
$errors= array();
$true= array();

if(isset($_POST['submit']) && count($_POST)>0){
		
		
	$email = trim(strip_tags($_POST['email']));

	if (empty($_POST["email"])) {
	     $errors[]=  'Adresse email manquante';
	}

	if(count($errors)<1){  		
			extract($_POST);
			
	        $result=$db->query("SELECT id,email, username, password FROM membres WHERE email='$email'");
	        $result=$result->fetchAll();
	        $vusername = $result[0]['username'];


	        if (!empty($result)){
	        	$password= md5(clo531P9La4124sjq);
	    		
	    		$query="UPDATE membres SET password='$password' WHERE email='$email'";
	    		$result=$db->exec($query);

		    $true[]= 'Vos identifiants vous ont été envoyés par email ';
		    
		   	//envoyer email 
		   		$to = $_POST["email"];

		   		$subject = "Vos identifiants";

		   		$headers = "From: close@places.com\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";  		 

		   		$vpassword = "clo531P9La4124sjq";
				
				$message = '<html><body>';
				$message .= '<h2>Bonjour,</h2>';
				$message .= '<h3>vous trouverez vos données ci-dessous<h3>';
				$message .= '<br />';
				$message .= '<h5>vos données</h5>';
				$message .= 'Votre nom d \'utilisateur:'.$vusername;
				$message .= '<br />';
				$message .= 'Votre nouveau mot de passe :'.$vpassword;
				$message .= '<br /><br />';
				$message .= 'Pour plus de comfort, changer votre mot de passe lors de votre prochaine connexion.';
				$message .= '<br />';
				$message .= '<p>Ceci est un message automatique, veuillez ne pas répondre directement à ce message.</p> ';
				
				$message .= '</body></html>';

				mail($to, $subject, $message, $headers);
				
			
		}else{
			$errors[]= 'email pas valide';	
		}
	}
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
   <title>Identifiants oubliés | ClosePlaces</title>

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
			<li><a href="login.php"><i class="fa fa-sign-in"></i> Connexion</a></li>
		</ul>
	</nav>
	<div id="container">
		<form action="email.php" method="post" onsubmit="return validateForm();" name="myForm">
			<section id="regForm">
				<h1>Récupération de compte</h1>
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
				<?php
					if($_POST && count($true)>0){
				?>
				<ul class="green">
				<?php
					foreach($true as $t){
						echo "<li><i class='fa fa-check'> </i> $t</li>";
					}
				?>
				</ul>
				<?php
					}
				?>
				<div class="reg">
					<label for="email">Adresse email <span class="rouge">*</span></label>
					<input type="email" name="email" id="email" placeholder="exemple@exemple.com" value="<?php if(!empty($_POST['email'])){echo $_POST['email'];} ?>">
				</div>
			</section>
			<p><b>(<span class="rouge">*</span>) Champ obligatoire</b></p>
			<input type="submit" name="submit" class="regsub" id="submit" value="Envoyer">
		</form>
	</div>	
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript">
	//validation form js
	$(function validateForm(){
		$("#submit").click(function(){
			$('.error') .remove();			 
			var email = document.forms["myForm"]["email"].value; 
			var atpos = email.indexOf("@");
    		var dotpos = email.lastIndexOf(".");
			var errors = false;

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