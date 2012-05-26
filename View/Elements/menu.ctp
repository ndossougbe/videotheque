<!-- Récupération d'objets dans un élément. peuvent être ensuite utilisés.-->
<!--<?php /*videos = $this->requestAction(array('controller' => 'videos', 'action' => 'menu'));*/?>-->
<?
	if(isset($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin'){
		$admin = true;
		$cakeDescription = __d('cake_dev', 'Vidéothèque - Administration');
	}else{
		$admin = false;
		$cakeDescription = __d('cake_dev', 'Vidéothèque');
	}

	
?>
<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</a>
	<?php echo $this->Html->link($cakeDescription, '/',array('class' => 'brand'));?>
<div class="nav-collapse">
	<ul class="nav">
		<li><?php echo $this->Html->link("Accueil", '/'); ?></li>
		<li><?php echo $this->Html->link("Catalogue", array('action' => 'index', 'controller' => 'videos'));?></li>

		<?php if ($admin): ?>
			<li><?php echo $this->Html->link("Ajouter une vidéo", array('controller' => 'videos','action' => 'edit')); ?></li>	
		<?php endif ?>
	</ul>
</div><!--/.nav-collapse -->