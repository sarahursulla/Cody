<?php
  session_start();
  include("../php/db_connect.inc.php");
  include("../php/script.php");
  include("../php/header.php");
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<title>Cody, en savoir plus sur Cody</title>
  	<link rel="shortcut icon" href="../assets/images/gt_favicon.png">
  	<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
  	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  	<link rel="stylesheet" href="../assets/css/font-awesome.min.css">
  	<link rel="stylesheet" href="../assets/css/bootstrap-theme.css" media="screen">
  	<link rel="stylesheet" href="../assets/css/main.css">
  </head>
  <body>
  	<!-- Fixed navbar -->
  	<div class="navbar navbar-inverse navbar-fixed-top headroom">
  		<div class="container">
  			<div class="navbar-header">
  				<!-- Button for smallest screens -->
  				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
  				<a class="navbar-brand" href="./index.php"><img src="../assets/images/logo.png" width="25%" alt="Cody HTML5 template"></a>
  			</div>
  			<div class="navbar-collapse collapse">
  				<ul class="nav navbar-nav pull-right">
  					<li><a href="./index.php">Accueil</a></li>
  					<li class="active"><a href="about.php">En savoir plus sur Cody</a></li>
  					<?php entete($_SESSION["MODE"]);?>
  				</ul>
  			</div><!--/.nav-collapse -->
  		</div>
  	</div>
  	<!-- /.navbar -->
  	<header id="head" class="secondary"></header>
  	<!-- container -->
  	<div class="container">
  		<ol class="breadcrumb">
        <li><a href="./index.php">Accueil</a></li>
        <li class="active">En savoir plus sur Cody</li>
  		</ol>
  		<div class="row">
  			<!-- Article main content -->
  			<article class="col-sm-8 maincontent">
  				<header class="page-header">
  					<h1 class="page-title">Quelques mots sur l'assitant virtuel Cody</h1>
  				</header>
  				<h3>Un besoin, une solution</h3>
  				<p><img src="../assets/images/mac.jpg" alt="mac" class="img-rounded pull-right" id="imgAbout" width="300">Imaginé par les analystes programmeurs de la CodingFactory byItescia, l'assistant virtuel Cody répond à un besoin d'abord identifié par ces mêmes codeurs et ensuite confirmé par les élèves, les intervenants et l'équipe pédagogique d'Itescia.</p>
  				<h3>L'accès aux notes pour les élèves</h3>
  				<p>Point de douleur principal pour les élèves, les notes sont maintenant disponibles facilement. Il suffit de se connecter pour connaitre toutes les notes, les appréciations et les moyennes.<br><br>
  				L'accès au planning des cours, au planning des labdays, à la liste des projets de la coding, le statut en temps réel de la certification, l'outil de création des groupes de travail... sont autant de fonctionnalités qui vont changer la vie des élèves de la CodingFactory, et par la suite d'Itescia et des autres écoles.</p>
  				<h3>Une gestion des notes facilitée pour les intervenants</h3>
  				<p>L'ajout des notes est maintenant simple et rapide, que ce soit par élèves ou par groupe d'élèves, l'intervenant n'a qu'à se connecter et choisir pour qui il veut entrer ou modifier des notes. De plus, il sera notifié pour rapidement entrer les notes d'un cours récemment donné.<br><br>
  				Nous allons aussi proposer la possibilité de créer et diffuser rapidement, à un format défini les users stories pour chaque classe.</p>
  				<h3>Améliorer le travail de l'équipe pédagogique: une priorité</h3>
  				<p>Consulter, ou modifier les notes d'un élève, d'une classe, une moyenne, être notifié d'un ajout de notes... Tout cela est déjà disponible avec Cody !<br><br>
  				Et bientôt, la gestion des plannings, la notification d'absences, la notification d'ajout de nouveaux documents téléchargés par les élèves...</p><br>
  				<p>Cody pourra être disponible pour d'autres écoles avec toutes ses fonctionnalités innovantes et bien d'autres à venir</p>
  			</article>
  			<!-- /Article -->
  		</div>
  	</div>	<!-- /container -->
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
