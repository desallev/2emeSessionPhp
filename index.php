<?php
include('dbconnexion.php');
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
  <title>Accueil | ClosePlaces</title>
<style type="text/css">



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

    <?php
      $result = $db->query("SELECT * FROM articles ORDER BY RAND() LIMIT 0,5");
      $result = $result->fetchAll();
      echo "<section class='introphoto' style='background:#45B29D  url(members/".$result[0]['id']."/articles/".$result[0]['id_article']."/pcover.jpg)no-repeat center center;-webkit-background-size: cover;
      -moz-background-size: cover;-o-background-size: cover;-ms-background-size: cover;background-size: cover;background-attachment: fixed;'>";
      echo "<div class='topmenu'>
      <a class='left' href='register.php'>S'inscrire </a>
      <a  class='right'href='login.php'>Se connecter</a>
          </div>

    <div id='container'>
      
      <h1 class='topcover'>ClosePlaces</h1>
      <p class='topp'>“A place without meaning is no place to be.”</br> <i>Wayne Gerard Trotman </i> </p>
      
    </div></section>";
    ?>
    <div class="fluid">  
      <div class="introicon">
          <div class="iconsintro">
              <p><i class="fa fa-globe"></i></p>
              <h2>Des endroits<br> extraordinaires </h2>
          </div>
          <div class="iconsintro">
              <p><i class="fa fa-picture-o"></i></p>
              <h2>Des photos de lieux <br>insoupçonnés</h2>
          </div>
          <div class="iconsintro">
              <p><i class="fa fa-history"></i></p>
              <h2>Des histoires <br>insolites</h2>
          </div>
          <div class="iconsintro">
              <p><span><i class="fa fa-heart"></i></span></p>
              <h2>Une communauté <br>solidaire</h2>
          </div>
      </div>
  </div>

  <section class="pintro"><p>ClosePlaces est un site qui regroupe et partage des endroits insolites où l'histoire s'est arrêtée.</p> 
    <p>Vous pourrez publier,via notre plateforme communautaire, <b>vos expériences</b>, <b>vos souvenirs </b>ou <b>vos connaissances </b> au travers de <b>photos</b>, <b>vidéos</b> et <b>articles</b>. </p>
    <p>Notre plateforme, vous proposera <b>des promenades</b> dans des villes fantômes, des bâtiments désaffectés, des prisons et des hôpitaux hors-service, des églises détruites par le temps... </p>
    <p><b> En un seul clic !</b></p>
  </section>
  
 <div class="ignite-cta text-center">
  <h2>Envie de partager ou tout simplement découvrir des trésors architecturaux ?</h2>
   <p><span>Devenez membre dès maintenant !</span></p>
    <div class="container">
      <div class="row">
        <div class="col-md-12">

          <a href="register.php" class="ignite-btn bord">S'inscrire</a>          
          <a href="login.php" class="ignite-btn">Se connecter</a>
        </div>
      </div>
    </div>
  </div>
  <div class="banderol"></div> 
   <div class="grid">
    
    <?php    
      $result = $db->query("SELECT * FROM articles ORDER BY RAND() DESC LIMIT 0,5  ");
      $result = $result->fetchAll();
      foreach ($result as $result) {
        extract($result);
        echo "              
        <figure class='imageintro'>
          <img src='./members/$id/articles/$id_article/pcover.jpg' >
               
        </figure>";
      }
    ?>
  </div>
  
  
  <footer>
    <p>© ClosePlaces - Tous droits réservés - <a href="credit.php">Crédits</a></p>
  </footer>
</body>
<html>