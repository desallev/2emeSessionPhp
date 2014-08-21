<?php
include('dbconnexion.php');
if($_SESSION['logged_in'] == true){
	$id =$_SESSION['id'];

	$query=$db->prepare('SELECT username, avatar, fname, email, lname, date FROM membres WHERE id=:id');
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

			
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {


		    
			 
			if ((empty($_POST["email"])) || (empty($_POST["fname"]))|| (empty($_POST["lname"]))) {
	    	 $errors[]=  'Tous les champs ne sont pas remplis';
	    	}
	    	
	    	
	    	if(count($errors)<1){
	    		$nomavatar=(!empty($_FILES['avatar']['size']))?move_avatar($_FILES['avatar']):''; 
	    		extract($_POST);
	    		$id =$_SESSION['id'];
	    		$query=$db->prepare('UPDATE membres SET avatar=?,fname=?, lname=?, email=? WHERE id=?');
	    		
			    $query->execute(array($avatar,$fname,$lname,$email,$id));
			    
			    $query=$db->prepare('SELECT username, avatar, fname, email, lname FROM membres WHERE id=:id');
			    $query->bindValue(':id',$id,PDO::PARAM_INT);
			    $query->execute();
			    $data=$query->fetch();
			    echo "<script>alert(\"✓ mise à jours des données réussi\")</script>";
				
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
  <link rel="stylesheet" type="text/css" href="css/normalize.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <title>Modifier son profil</title>
</head>
<body>

<a href="login.php"><button id="modifpro" class="modifpro"><i class="fa fa-reply"></i> Mon profil </button></a>
<div id="container">

	<h1>Votre profil</h1>
	<?php
// if form has been submitted, show the errors
if($_POST && count($avatar_erreur)>0){
?>
	
	
	<ul class="red">
	<?php
	foreach($avatar_erreur as $a){ 
		echo "<li><i class='fa fa-times'></i> $a</li>";
	}
?>
	</ul>

	<?php
}
?>

	<form method="post" action="modifier.php" onsubmit="return validateForm();" name="myForm">
	    <section class="photo">
	     	<div class="avatarphoto">
	     	<?php if(empty ($data['avatar'])){
				echo '<img src="http://www.gravatar.com/avatar/'.md5($data['email']).'?s=170"/>
				</div><div class="avatartxt">
				<h3>Photo de profile</h3>
				<p>Votre photo de profile par défaut est lié à votre compte <a href="https://fr.gravatar.com/">Gravatar</a>.</p>
				<div class="bold"><label for="avatar">Choisissez votre avatar :</label><input type="file" name="avatar" id="avatar" /></div>
								
			</div>';
			} else {
				echo '<img src="'.$data['avatar'].'"/>
				</div><div class="avatartxt">
				<h3>Photo de profile</h3>	

				<div class="bold"><label for="avatar">Choisissez votre avatar :</label><input type="file" name="avatar" id="avatar" /></div>
				</div>';
			}
			?>
			
			
	    </section>
	<?php
// if form has been submitted, show the errors
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
	    <section class="init">
			<div class="strong"><label for="username">votre nom d'utilisateur (non éditable) </label><strong><?php echo ''.stripslashes(htmlspecialchars($data['username'])).''?></strong> </div>
			<div class="modif"><label for="fname">votre prénom <span class="rouge">*</span></label><input type="text" name="fname" id="fname" <?php echo 'value="'.stripslashes(htmlspecialchars($data['fname'])).'"'?>></div>
			<div class="modif"><label for="lname">votre nom de famille <span class="rouge">*</span></label><input type="text" name="lname" id="lname" <?php echo 'value="'.stripslashes(htmlspecialchars($data['lname'])).'"'?>></div>
			<div class="modif"><label for="email">Votre adresse E_Mail <span class="rouge">*</span></label><input type="text" name="email" id="email" <?php echo 'value="'.stripslashes($data['email']).'" '?>/></div>
		</section>
		<p><b>(<span class="rouge">*</span>) Champ obligatoire</b></p>
		<input type="submit" name="submit" class="modifpro vert" id="submit" value="Modifier" />
		<button class="bttntop"><a href="#modifpro">Top</a> </button>

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
	<p>© ClosePlaces - Tous droits réservés</p>
</footer>
</body>
<html>