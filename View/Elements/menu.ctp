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
<div class="menu">
	<ul class='nav'>
		<li><span id="titre"><?php echo $this->Html->link($cakeDescription, '/'); ?></span></li>
		<li>
			<?php echo $this->Html->link("Catalogue", array('action' => 'index', 'controller' => 'videos'));?>
		</li>
		<li>
			
		</li>

		<?php if ($admin): ?>
		<li>
			<?php echo $this->Html->link("Ajouter une vidéo", array('controller' => 'videos','action' => 'edit')); ?>
		</li>	
		<?php endif ?>
		
		
	</ul>
</div>
