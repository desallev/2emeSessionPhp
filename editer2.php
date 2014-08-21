<?php
include('dbconnexion.php');
$errors= array();
if($_SESSION['logged_in'] == true){
	$id = $_GET['id']=$_SESSION['id'];
	$id_article = $_GET['id_article'];


	$query=$db->prepare('SELECT * FROM articles WHERE id=:id and id_article=:id_article');
	$query->bindValue(':id',$id,PDO::PARAM_INT);
	$query->bindValue(':id_article',$id_article,PDO::PARAM_INT);
	$query->execute();
	$data=$query->fetch();	
	
	$query=$db->query("SELECT id FROM articles WHERE id='$id' AND user='$user'");
	if (empty($query)){
		  header("Location: login.php");      	
		        	
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
			if(file_exists("members/$id/articles/$id_article/pcover.jpg")){
				unlink("members/$id/articles/$id_article/pcover.jpg");
			}
			$move_image=move_uploaded_file($file_tmp,"members/$id/articles/$id_article/pcover.jpg");
			$ok_msg = "Votre photo de couverture à été mise à jour.";
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
  <link href='http://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'>
  <title>Modifier sa photo  |  ClosePlaces</title>
  <style type="text/css">
  .couverture{
  	width: 700px;
  	margin-top: 50px;
  }
  .couvtxt{

  }
  </style>
  
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
		<li><a href="editer.php?id_article=<?php echo $id_article?>"><i class="fa fa-reply"></i> <span>Retour</span> </a></li>
		<li><a href="login.php"><i class="fa fa-user"></i> Mon profil</a></li>
		<li><a href="logout.php"><i class="fa fa-sign-out"></i> Déconnexion</a></li>
					
				</ul>
			</nav>

<div id="container">






	<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']  ?>"  enctype="multipart/form-data">	    
		<form method="post" action="modifier.php" onsubmit="return validateForm();" name="myForm">
	    <div class="couverture">
	    		<h1>Modifier votre photo de couverture</h1>
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
	     	
	     	<?php if(!isset($_POST['submit'])){ echo '
				
				<img src="./members/'.$data['id'].'/articles/'.$data['id_article'].'/pcover.jpg" width="700" />
				
				<h3>Mettre à jour votre photo du couverture</h3>	

				<div class="bold"><label for="avatar">Choisissez une photo :</label><input type="file" name="new_file"></div>
				<input type="submit" name="submit" class="regsub" id="submit" value="Modifier" />

				</div>';
				
				
			}else{echo '
				<img src="./members/'.$data['id'].'/articles/'.$data['id_article'].'/pcover.jpg" width="700" />
				
				<h3>Mettre à jour votre photo du couverture</h3>	

				<div class="bold"><label for="avatar">Choisissez une photo :</label><input type="file" name="new_file"></div>
				<input type="submit" name="submit" class="regsub" id="submit" value="Modifier" />

				</div>';

			}
			?>
			
			
	    </div>
		
		
		

	</form>	
</div>
<footer><p>© ClosePlaces - Tous droits réservés - <a href="credit.php">Crédits</a></p></footer>
</body>
<html>