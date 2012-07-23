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


<?php echo $this->Html->link($cakeDescription, '/',array('class' => 'brand', 'tabindex' => -1));?>
<div class="nav-collapse">
	<ul class="nav">
		<li><?php echo $this->Html->link("Accueil", '/', array('tabindex' => -1)); ?></li>
		<li><?php echo $this->Html->link("Catalogue", array('action' => 'index', 'controller' => 'videos'), array('tabindex' => -1));?></li>

		<?php if ($admin): ?>
			<li><?php echo $this->Html->link("Ajouter une vidéo", array('controller' => 'videos','action' => 'edit'), array('tabindex' => -1)); ?></li>	
		<?php endif ?>
	</ul>
</div><!--/.nav-collapse -->