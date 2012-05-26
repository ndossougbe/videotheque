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
	<link rel="stylesheet/less" href="<?php echo $this->Html->url('/css/style.less'); ?>"/>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('bootstrap');
		echo $this->Html->css('bootstrap-responsive');
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
        <div class="container">
        	<?php echo $this->element('menu'); ?>
        </div>
      </div>
    </div>

    <div class="container">
		<?php echo $this->Session->flash(); ?>
		<?php echo $content_for_layout; ?>
    </div> <!-- /container -->

    <?php echo $this->element('sql_dump'); ?>
    <?php
    	echo $this->Html->script('jquery');
    	echo $this->Html->script('bootstrap');
    	echo $scripts_for_layout;
    ?>

  </body>
</html>