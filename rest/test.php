<?php

if(isset($_POST['submit']) ){
	
 print_r($_FILES);
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

		

	<div id="container">
		<form action="test.php" method="post" enctype="multipart/form-data">
		<section id="regForm">
		<h1>Nouveau lieu, nouvel article</h1>

			<div class="reg"><label for="pcover">Photo de couverture <span class="rouge">*</span></label>
				<input type="file" name="pcover" ></div>


			
		</section>
		<p><b>(<span class="rouge">*</span>) Champ obligatoire</b></p>
		<input type="submit" name="submit" class="regsub" id="submit" value="Créer">
				
				
		</form>
	</div>


	
</body>
</html>