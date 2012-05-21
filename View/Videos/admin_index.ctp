<div class="page-header">
	<h1>Gérer les vidéos</h1>
</div>

<table>
	<tr>
		<th>ID</th>
		<th>Titre</th>
		<th>Format</th>
		<th>Actions</th>
	</tr>

	<?php foreach ($videos as $k => $v): $v = current($v); ?>
	<tr>
		<td><?php echo $v['id'] ?></td>
		<td><?php echo $v['name'] ?></td>
		<td><?php echo $v['format_id'] ?></td>
		<td>
			<?php echo $this->Html->link("Editer", array('action' => 'edit', $v['id'])); ?> -

			<!-- Fait apparaître une popup de confirmation -->
			<?php echo $this->Html->link("Supprimer", array('action' => 'delete', $v['id']),null,'Voulez vous vraiment supprimer cette entrée?'); ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>

<?php echo $this->Paginator->numbers() ?>