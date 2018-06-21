	<!-- Connection database -->
  <?php
  session_start();
  include("../php/db_connect.inc.php");
  include("../php/script.php");
?>


<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <script src="main.js"></script>
  
  <title>Cody - Équipe pédagogique</title>

	<link rel="shortcut icon" href="../assets/images/gt_favicon.png">

	<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="../assets/css/bootstrap-theme.css" media="screen" >
	<link rel="stylesheet" href="../assets/css/main.css">
</head>

<body>
	<!-- Fixed navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top headroom" >
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				<a class="navbar-brand" href="../index.html"><img src="../assets/images/logo.png" width="25%" alt="Cody HTML5 template"></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
					<li><a href="../index.html">Accueil</a></li>
					<li class="active"><a href="about.php">En savoir plus sur Cody</a></li>
					<li><a class="btn" href="../php/logout.php">DÉCONNEXION</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>
	<!-- /.navbar -->

	<!-- data table -->
 	<section id="head" class="secondary"></section>
	<div id="mainContent">
	<?php equipePedagogique();?>
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
							<p>C'est pour cela que nous avons eu l'idée de crée Cody, un assistant virtuel qui faciliterait la vie et le travail de tous. </p>
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
