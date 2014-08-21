<?php
include('dbconnexion.php');
if($_SESSION['logged_in'] == true){
	$id = $_GET['id'];
if(isset($_SESSION['logged_in'])&&$_SESSION['id']== $id){
	$pageOwner = true;
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

  <title>créer un nouvelle article | ClosePlaces</title>
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
					<li><a href="listeart.php">ClosePlaces</a></li>

		<?php if(isset($pageOwner)): ?>
					<li><a href="#"><i class="fa fa-pencil"></i> <span>Créer un nouvelle article</span> </a></li>
		
					<li><a href="#"><i class="fa fa-pencil-square-o"></i> <span>Editer votre article</span></a></li>
					<li><a href="#"><i class="fa fa-trash-o"></i> <span>Supprimer votre article</span></a></li>
					
					
		<?php else:?>
			<li><a href="login.php"><i class="fa fa-user"></i> <span>Mon profil</span></a></li>	
			<li><a href="#"><i class="fa fa-pencil"></i> <span>Créer un nouvelle article</span> </a></li>
				
		<?php endif;?>
		<li><a href="logout.php"><i class="fa fa-sign-out"></i> <span>Déconnexion</span></a></li>
					
				</ul>
			</nav>

	
</body>
</html>



/*voir et supprimer*/