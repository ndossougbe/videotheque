<?php

$cakeDescription = __d('cake_dev', 'Videothèque');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<!-- Fichiers.less: pas un fichier.css, il faut l'inclure comme ceci: -->
	<link rel="stylesheet/less" href="<?php echo $this->Html->url('/css/style.less'); ?>"/>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		echo $scripts_for_layout;

		echo $this->Html->script('less');
		echo $this->Html->script('jquery');
		if(isset($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin'){
			echo $this->Html->script('admin');
		}
	?>

</head>
<body>
	<div id="container">
		<div id="header">
			<!-- Affichage du menu (cf View/Elements/menu.ctp) -->
			<?php echo $this->element('menu'); ?>
		</div>
		
		<div id="content">
			<!-- Affichage des notifications (messages passés dans Session->flash) -->
			<?php echo $this->Session->flash(); ?>
			<?php echo $content_for_layout; ?>
		</div>
		
		
		
		
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt'=> 'cakePHP', 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
