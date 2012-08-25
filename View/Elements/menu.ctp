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
	
<?php echo $this->Html->link($cakeDescription, array('action' => 'index', 'controller' => 'videos'), array('class' => 'brand', 'tabindex' => -1));?>
<div class="nav-collapse">
	<ul class="nav">
		<!-- <li><?php echo $this->Html->link("Accueil", '/', array('tabindex' => -1)); ?></li> -->
		<li><?php echo $this->Html->link("Catalogue", array('action' => 'index', 'controller' => 'videos'), array('tabindex' => -1));?></li>

		<?php if ($admin): ?>
			<li><?php echo $this->Html->link("Ajouter une vidéo", array('controller' => 'videos','action' => 'edit'), array('tabindex' => -1)); ?></li>
		<?php endif ?>
	</ul>

	<ul class="nav" style="float:right">
		<?php if ($this->Session->read('Auth.User')): ?>
			<li><?php echo $this->Html->link("Se déconnecter", array('action' => 'logout', 'controller' => 'users')); ?></li>
		<?php else: ?>
			<li><?php echo $this->Html->link("Zone admin", array('action' => 'login', 'controller' => 'users')); ?></li>
		<?php endif ?>
	</ul>
</div><!--/.nav-collapse -->