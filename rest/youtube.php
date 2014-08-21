<?php

		    if(isset($_POST['yvideo'])){
		    	$yvideo = $_POST['yvideo'];
		    	$yvideo = explode('=',$yvideo);
		    	$video = $yvideo['1'];
		    	?>

		    	<iframe width='700' height='350' src='http://www.youtube.com/embed/<?php echo '$video';?>' frameborder='0'allowfullscreen ></iframe>
		   <?php }

	
?>
<!DOCTYPE html>
<html lang="fr">
<head>

</head>
<body>

		<form action="youtube.php" method="post"  >


		<div class="reg"><label for="yvideo">Video du lieu (seule les liens Youtube sont fonctionnels)</label><input type="text" name="yvideo" id="yvideo" placeholder="https://www.youtube.com/watch?v=3Ger9exVd2I"
				value="<?php if(!empty($_POST['yvideo'])){echo $_POST['yvideo'];} ?>"></div>
			
		
		<input type="submit" name="submit" class="regsub" id="submit" value="Créer">
				
				
		</form>
	</div>
	

	
</body>
</html>


