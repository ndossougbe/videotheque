<?php

$cakeDescription = __d('cake_dev', 'Videothèque');
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
  	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?> - 
		<?php echo $title_for_layout; ?>
	</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

	<!-- Fichiers.less: pas un fichier.css, il faut l'inclure comme ceci: -->
  <link rel="stylesheet/less" type="text/css" href="<?php echo $this->Html->url('/less/bootstrap.less'); ?>"/>
  <link rel="stylesheet/less" type="text/css" href="<?php echo $this->Html->url('/less/style.less'); ?>"/>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->script('less');
	?>
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container" id="menu">
        	<?php echo $this->element('menu'); ?>
        </div>
      </div>
    </div>

    <div class="container">
  		<?php echo $this->Session->flash(); ?>
  		<?php echo $content_for_layout; ?>


      <footer class="footer">
      <p>
        Style d'après <a href="http://twitter.github.com/bootstrap">Twitter Bootstrap</a>, sous <a href="http://www.apache.org/licenses/LICENSE-2.0">Licence Apache v2.0</a><br>
        Icones de <a href="http://glyphicons.com">Glyphicons Free</a>, sous licence <a href="http://creativecommons.org/licenses/by/3.0/">CC BY 3.0</a>
      </p> 
    </footer>
    </div> <!-- /container -->

    <?php echo $this->element('sql_dump'); ?>
    <!--><script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>-->
    <?php
    	echo $this->Html->script('jquery');
      echo $this->Html->script('global_functions');
    	echo $scripts_for_layout;
    ?>
  </body>
</html>