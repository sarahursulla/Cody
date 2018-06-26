  	<!-- Connexion bdd, script et headers -->
<?php
  session_start();
  include("../php/db_connect.inc.php");
  include("../php/script.php");
?>

  	<!-- liens vers feuilles de style, ressources...-->
<!DOCTYPE html>
<html lang="fr">
  <head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<title>Cody, assistant virtuel Itescia</title>
  	<link rel="shortcut icon" href="../assets/images/gt_favicon.png">
  	<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
  	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  	<link rel="stylesheet" href="../assets/css/font-awesome.min.css">
  	<link rel="stylesheet" href="../assets/css/bootstrap-theme.css" media="screen">
  	<link rel="stylesheet" href="../assets/css/main.css">
  </head>
  <body>
  	<div class="navbar navbar-inverse navbar-fixed-top headroom">
  		<div class="container">
  			<div class="navbar-header">
  				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
  				<a class="navbar-brand" href="./index.php"><img src="../assets/images/logo.png" width="25%" alt="Cody HTML5 template"></a>
  			</div>
  			<div class="navbar-collapse collapse">
  				<ul class="nav navbar-nav pull-right">
  					<li><a href="./index.php">Accueil</a></li>
  					<li><a href="about.php">En savoir plus sur Cody</a></li>
  					<li class="active"><a class="btn" href="signin.php">CONNEXION</a></li>
  				</ul>
  			</div><
  		</div>
  	</div>
  	<header id="head" class="secondary"></header>
	<!-- chemin pages -->
	<div class="container">
  		<ol class="breadcrumb">
        <li><a href="./index.php">Accueil</a></li>
        <li class="active">Connexion</li>
  		</ol>
  		<div class="row">
  			<!-- Accès espace personnel-->
  			<article class="col-xs-12 maincontent">
  				<header class="page-header">
  					<h1 class="page-title">Espace personnel Itescia</h1>
  				</header>
  				<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
  					<div class="panel panel-default">
  						<div class="panel-body">
  							<h3 class="thin text-center">Connexion</h3>
  							<p class="text-center text-muted">Par mesure de sécurité, </br>veuillez choisir un nouveau mot de passe qui vous est propre.</p>
  							<hr>
  							<form method="post">
  								<div class="top-margin">
  									<label>Nouveau mot de passe<span class="text-danger">*</span></label>
  									<input type="password" name="pass1" class="form-control" required/>
  								</div>
  								<div class="top-margin">
  									<label>Confirmez le nouveau mot de passe<span class="text-danger">*</span></label>
  									<input type="password" name="pass2" class="form-control" required/>
  								</div>
  								<hr>
  								<div class="row">
                    <div class="col-lg-8">
  									</div>
  									<div class="col-lg-4 text-right">
  									<input type="submit" name="changermdp" value="Changer" class="btn btn-action"/>
  									</div>
  								</div>
  							</form>
  						</div>
  					</div>
  				</div>
  			</article>
  		</div>
	  </div>
	<!-- footer -->
  	<footer id="footer" class="top-space">
  		<div class="footer1">
  			<div class="container">
  				<div class="row">
  					<div class="col-md-3 widget">
  						<h3 class="widget-title">Contact</h3>
  						<div class="widget-body">
  								<a href="mailto:#">sarah.bonose@edu.itescia.fr</a>
  								<a href="mailto:#">nicolas.coquillaud@edu.itescia.fr</a>
  								<a href="mailto:#">loic.mauvoisin@edu.itescia.fr</a></br>
  							</br>
  							    TheAvatarsTeam</br>
  								CodingFactorybyItescia</br>
  								35 Boulevard du port</br>
  								Cergy-Pontoise</br>
  								95000</br>
  								France
  							</p>
  						</div>
  					</div>
  					<div class="col-md-6 widget">
  						<h3 class="widget-title">Pourquoi Cody ?</h3>
  						<div class="widget-body">
  							<p>Notre année à la CodingFactory by Itescia se termine sur un projet à rendre en équipe. Sarah, Nicolas et moi-même avons décidé d'améliorer le quotidien des acteurs de notre école.</p>
  							<p>C'est pour cela que nous avons eu l'idée de créer Cody, un assistant virtuel qui faciliterait la vie et le travail de tous.</p>
  							<p>Loïc de l'AvatarsTeam  </p>
  						</div>
  					</div>
  				</div>
  			</div>
  		</div>
  		<div class="footer2">
  			<div class="container">
  				<div class="row">
  					<div class="col-md-6 widget">
  						<div class="widget-body">
  							<p class="simplenav">
  								<a href="./index.php">Home</a> |
  								<a href="about.php">En savoir plus sur Cody</a>
  							</p>
  						</div>
  					</div>
  					<div class="col-md-6 widget">
  						<div class="widget-body">
  							<p class="text-right">
  								Copyright &copy; 2018  Designed by The Avatars team
  							</p>
  						</div>
  					</div>
  				</div>
  			</div>
  		</div>
  	</footer>
	 <!-- JavaScript bibliothèques placés en bas pour chargement plus rapide -->
	 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
  	<script src="../assets/js/headroom.min.js"></script>
  	<script src="../assets/js/jQuery.headroom.min.js"></script>
  	<script src="../assets/js/template.js"></script>
  </body>
</html>
