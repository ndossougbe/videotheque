<?
	if(isset($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin'){
		$admin = true;
	}else{
		$admin = false;
	}

	function outputcsv($array){
		$ret = "";
		foreach ($array as $k => $v) {
			$ret = $ret.$v["name"];
			if($k != sizeof($array) - 1) $ret = $ret.", ";
		}
		return $ret;
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
		<th>Titre</th>
		<th>Format</th>
		<th>Genre</th>
		<?php if ($admin): ?>
			<th>Actions</th>	
		<?php endif ?>
		
	</thead>


	<?php foreach ($videos as $k => $v): ?>
	<tr>
		<td><?php
		echo $this->Html->link($v['Video']['name'], array('action' => 'show', $v['Video']['id']), array(
			'rel'					=> 'popover',
			'data-content'			=> '
				<div>
					<table>
						<tbody>
							<td>'.$this->Html->image($v['Video']["cover"] ,array("style" => "max-width: 200px")).'</td>
							<td>
								<h4>Synopsis:</h4>
								<p>'.$v['Video']["synopsis"].'</p>
								<h4>Avec:</h4>
								<p>'.outputcsv($v["Actors"]).'</p>
							</td>
						</tbody>
					</table>
				</div>	
			',
			'data-placement'		=> 'bottom',
		), null);
		?></td>


		<td><?php echo $v['Format']['name'] ?></td>


		<td><?php echo outputcsv($v['CategoriesVids']); ?></td>

		<?php if ($admin): ?>
		<td>
			<?php echo $this->Html->link("Editer", array('action' => 'edit', $v['Video']['id'])); ?> -

			<!-- Fait apparaître une popup de confirmation -->
			<?php echo $this->Html->link("Supprimer", array('action' => 'delete', $v['Video']['id']),null,'Voulez vous vraiment supprimer cette entrée?'); ?>
		</td>
		<?php endif ?>
	</tr>
	<?php endforeach; ?>
</table>


<?php echo $this->Paginator->numbers() ?>
<?php echo $this->Html->script('bootstrap-tooltip',array('inline' => false)); ?>
<?php echo $this->Html->script('bootstrap-popover',array('inline' => false)); ?>

<?php 
	$this->Html->scriptStart(array('inline'=>false));
	echo "$('a[rel=popover]').popover();";
	$this->Html->scriptEnd();
?>
