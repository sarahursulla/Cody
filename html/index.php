<?php
  session_start();
  include("../php/db_connect.inc.php");
  include("../php/script.php");
  include("../php/header.php");
  if (!($_SESSION["MODE"] >= 0 && $_SESSION["MODE"] <= 3)) {
    $_SESSION["MODE"] = 0;
  }
?>

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
  <body class="home">
  	<!-- Fixed navbar -->
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
  			</div><!--/.nav-collapse -->
  		</div>
  	</div>
  	<!-- /.navbar -->
  	<!-- Header -->
  	<header id="head">
  		<div class="container">
  			<div class="row">
  			</div>
  		</div>
  	</header>
  	<!-- /Header -->
  	<!-- Intro -->
  	<div class="container text-center">
  		<br> <br>
  		<h2 class="thin">Cody, l'outil indispensable à toutes personnes connectées avec Itescia</h2>
  		<p class="text-muted">Facilitez-vous la vie grâce à Cody, un outil conçu par les analystes programmeurs d'Itescia.</p>
  	</div>
  	<!-- /Intro-->
  	<!-- Highlights - jumbotron -->
  	<div class="jumbotron top-space">
  		<div class="container">
  			<h3 class="text-center thin">A qui profite Cody ?</h3>
  			<div class="row">
  				<div class="col-md-3 col-sm-6 highlight">
  					<div class="h-caption"><h4><i class="fa fa-pencil"></i>Les élèves</h4></div>
  					<div class="h-body text-center">
  						<p>Accès instantané aux notes, au planning des cours, au planning des labdays, à la liste des projets de la coding. Statut de la certification en temps réel. Outil de création des groupes de travail...</p>
  					</div>
  				</div>
  				<div class="col-md-3 col-sm-6 highlight">
  					<div class="h-caption"><h4><i class="fa fa-paste"></i>Les intervenants</h4></div>
  					<div class="h-body text-center">
  						<p>Ajout des notes simple et rapide par élèves et par groupes, Création et diffusion rapide des users stories, rappel des notes à intégrer...</p>
  					</div>
  				</div>
  				<div class="col-md-3 col-sm-6 highlight">
  					<div class="h-caption"><h4><i class="fa fa-cogs"></i></i>L'équipe pédagogique</h4></div>
  					<div class="h-body text-center">
  						<p>Gestion des plannings, notification de nouvelles notes, notifications d'absences, notifications de nouveaux documents téléchargés...</p>
  					</div>
  				</div>
  				<div class="col-md-3 col-sm-6 highlight">
  					<div class="h-caption"><h4><i class="fa fa-home"></i>Les écoles innovantes</h4></div>
  					<div class="h-body text-center">
  						<p>Cody sera facilement disponible pour d'autres éoles avec toutes ses fonctionnalités innovantes et bien d'autres à venir</p>
  					</div>
  				</div>
  			</div> <!-- /row  -->
  		</div>
  	</div>
  	<!-- /Highlights -->
  	<!-- container -->
  	<div class="container">
  		<h2 class="text-center top-space">De nombreuses fonctionnalités bientôt disponibles, </h2>
  		<h3 class="text-center top-space">Cody vous rendra la vie encore plus facile !</h3>
  		</div> <!-- /row -->
    </div>	<!-- /container -->
  	<!-- Social links. @TODO: replace by link/instructions in template -->
  	<section id="social">
  		<div class="container">
  			<div class="wrapper clearfix">
  				<!-- AddThis Button BEGIN -->
  				<div class="addthis_toolbox addthis_default_style">
  				<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
  				<a class="addthis_button_tweet"></a>
  				<a class="addthis_button_linkedin_counter"></a>
  				<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
  				</div>
  				<!-- AddThis Button END -->
  			</div>
  		</div>
  	</section>
  	<!-- /social links -->
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
  				</div> <!-- /row of widgets -->
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
  				</div> <!-- /row of widgets -->
  			</div>
  		</div>
  	</footer>
  	<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
  	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
  	<script src="../assets/js/headroom.min.js"></script>
  	<script src="../assets/js/jQuery.headroom.min.js"></script>
  	<script src="../assets/js/template.js"></script>
  </body>
</html>
