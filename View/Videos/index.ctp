<?
	if(isset($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin'){
		$admin = true;
	}else{
		$admin = false;
	}	
?>

<div class="page-header">
	<?php if ($admin): ?>
		<h3>Gérer les films</h3>		
	<?php else: ?>
		<h3>Liste des films</h3>
	<?php endif ?>
</div>

<table class="table table-striped">
	<thead>
		<th>ID</th>
		<th>Titre</th>
		<th>Format</th>

		<?php if ($admin): ?>
			<th>Actions</th>	
		<?php endif ?>
		
	</thead>

	<?php foreach ($videos as $k => $v): $v = current($v); ?>
	<tr>
		<?php debug($v) ?>
		<td><?php echo $v['id'] ?></td>
		<td><?php echo $this->Html->link($v['name'],array('action' => 'show', $v['id']));?></td>
		<td><?php echo $videos[$k]['Format']['name'] ?></td>
		<?php if ($admin): ?>
		<td>
			<?php echo $this->Html->link("Editer", array('action' => 'edit', $v['id'])); ?> -

			<!-- Fait apparaître une popup de confirmation -->
			<?php echo $this->Html->link("Supprimer", array('action' => 'delete', $v['id']),null,'Voulez vous vraiment supprimer cette entrée?'); ?>
		</td>
		<?php endif ?>
	</tr>
	<?php endforeach; ?>
</table>

<?php echo $this->Paginator->numbers() ?>