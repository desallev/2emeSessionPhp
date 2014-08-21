<?php
	include('dbconnexion.php');
	if($_SESSION['logged_in'] == true){
		$id =$_SESSION['id'];
		$query=$db->prepare('SELECT username,  fname, email, lname, date FROM membres WHERE id=:id');
	    $query->bindValue(':id',$id,PDO::PARAM_INT);
	    $query->execute();
	    $data=$query->fetch();
		$errors= array(); 
		$avatar_erreur= array(); 
		if(isset($_POST['submit']) && count($_POST)>0){
			$username = trim(strip_tags($_POST['username']));
			$password = trim(strip_tags($_POST['password']));
			$fname = trim(strip_tags($_POST['fname']));
			$lname = trim(strip_tags($_POST['lname']));
			$email = trim(strip_tags($_POST['username']));			 
			if ((empty($_POST["email"])) || (empty($_POST["fname"]))|| (empty($_POST["lname"]))){
				$errors[]=  'Tous les champs ne sont pas remplis';
			}		
			if(count($errors)<1){
				
				extract($_POST);
				$id =$_SESSION['id'];
				$query=$db->prepare('UPDATE membres SET fname=?, lname=?, email=? WHERE id=?');			
			    $query->execute(array($fname,$lname,$email,$id));		    
			    $query=$db->prepare('SELECT username,  fname, email, lname FROM membres WHERE id=:id');
			    $query->bindValue(':id',$id,PDO::PARAM_INT);
			    $query->execute();
			    $data=$query->fetch();
			    $ok_msg = "Profil mis à jour.";			
			}
		} 	
	}else{
		header("Location: login.php");
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
	<title>Modifier votre profil  |  ClosePlaces</title>
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
			<li><a href="modifier2.php?id=<?php echo $id?>"><i class="fa fa-picture-o"></i> <span>Modifier votre photo</span></a></li>
			<li><a href="logout.php"><i class="fa fa-sign-out"></i> <span>Déconnexion</span></a></li>
		</ul>
	</nav>
	<div id="container">
		<form method="post" action="modifier.php" onsubmit="return validateForm();" name="myForm">
		<section class="init">
	 		<h1>Votre profil</h1>   
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
			<ul class="green">
			<?php
				if (isset($ok_msg)) {
					echo "<li><i class='fa fa-check'> </i>  $ok_msg  </li>";
				}
			?>
			</ul>	    
			<div class="strong">
				<label for="username">votre nom d'utilisateur (non éditable) </label>
				<strong><?php echo ''.stripslashes(htmlspecialchars($data['username'])).''?></strong> 
			</div>
			<div class="modif">
				<label for="fname">votre prénom <span class="rouge">*</span></label>
				<input type="text" name="fname" id="fname" <?php echo 'value="'.stripslashes(htmlspecialchars($data['fname'])).'"'?>>
			</div>
			<div class="modif">
				<label for="lname">votre nom de famille <span class="rouge">*</span></label>
				<input type="text" name="lname" id="lname" <?php echo 'value="'.stripslashes(htmlspecialchars($data['lname'])).'"'?>>
			</div>
			<div class="modif">
				<label for="email">Votre adresse E_Mail <span class="rouge">*</span></label>
				<input type="text" name="email" id="email" <?php echo 'value="'.stripslashes($data['email']).'" '?>/>
			</div>
		</section>
		<p><b>(<span class="rouge">*</span>) Champ obligatoire</b></p>
		<input type="submit" name="submit" class="regsub" id="submit" value="Modifier" />
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
				var email = document.forms["myForm"]["email"].value; 
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