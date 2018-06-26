  	<!-- Connexion bdd, script et headers -->
<?php
  session_start();
  include("../php/db_connect.inc.php");
  include("../php/script.php");
  include("../php/header.php");
  if (!(isset($_SESSION["MODE"]))) {
    $_SESSION["MODE"] = 0;
  }
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
    	<!-- Header -->
  <body class="home">
  	<div class="navbar navbar-inverse navbar-fixed-top headroom">
  		<div class="container">
  			<div class="navbar-header">
  				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
  				<a class="navbar-brand" href="index.php"><img src="../assets/images/logo.png" width="25%"  alt="Cody HTML5 template"></a>
  			</div>
  			<div class="navbar-collapse collapse">
  				<ul class="nav navbar-nav pull-right">
  					<li class="active"><a href="index.php">Accueil</a></li>
  					<li><a href="./about.php">En savoir plus sur Cody</a></li>
  					<?php entete($_SESSION["MODE"]);?>
  				</ul>
  			</div>
  		</div>
  	</div>
  	<header id="head">
  		<div class="container">
  			<div class="row">
  			</div>
  		</div>
  	</header>
  	<!-- punchline1 -->
  	<div class="container text-center">
  		<br><br>
  		<h2 class="thin">Cody, l'outil indispensable de la Coding Factory by ITESCIA</h2>
  	</div>
  	<!-- blocs descriptions -->
  	<div class="jumbotron top-space">
  		<div class="container">
  			<h3 class="text-center thin">Que propose Cody, assistant virtuel ? </h3>
  			<div class="row">
  				<div class="col-md-3 col-sm-6 highlight">
  					<div class="h-caption"><h4><i class="fa fa-pencil"></i>Elèves</h4></div>
  					<div class="h-body text-center">
  						<p>Chaque éléve de la Coding Factory peut consulter ses notes et sa moyenne générale.</p>
  					</div>
  				</div>
  				<div class="col-md-3 col-sm-6 highlight">
  					<div class="h-caption"><h4><i class="fa fa-paste"></i>Intervenants</h4></div>
  					<div class="h-body text-center">
  						<p>Chaque intervenant peut consultater et gérer les notes de leurs élèves et groupes. </p>
  					</div>
  				</div>
  				<div class="col-md-3 col-sm-6 highlight">
  					<div class="h-caption"><h4><i class="fa fa-cogs"></i></i>Equipe pédagogique</h4></div>
  					<div class="h-body text-center">
  						<p>L'équipe pédagogique peut consulter et gérer les notes par élèves ou par groupes pour toutes les matières.</p>
  					</div>
  				</div>
  				<div class="col-md-3 col-sm-6 highlight">
  					<div class="h-caption"><h4><i class="fa fa-home"></i>ITESCIA</h4></div>
  					<div class="h-body text-center">
  						<p>Bientôt disponible pour tous les poles ITESCIA et les prochaines écoles de la CCI</p>
  					</div>
  				</div>
  			</div>
  		</div>
  	</div>
  	<!-- punchline2 -->
  	<div class="container">
  		<h2 class="text-center top-space">Cody rend le travail de tous plus simple !</h2>
  		<h3 class="text-center top-space">Et il deviendra indispensable grâce aux nombreuses fonctionnalités qui seront bientôt disponibles.</h3>
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
  							<p>Notre année à la CodingFactory by Itescia se termine sur un projet à rendre en équipe. Sarah, Nicolas et Loic avons décidé d'améliorer le quotidien des acteurs de notre école.</p>
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
  								<a href="index.php">Home</a> |
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
