<?
	if(isset($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin'){
		$admin = true;
	}else{
		$admin = false;
	}

	function outputcsv($array, $list=false){
		$ret = array();
		foreach ($array as $k => $v) {
			if(gettype($v) == 'array'){
				$ret[] = $v['name'];	
			}
			else if($list){
				$ret[] = "'".$v."'";
			}
			
		}
		return implode(', ',$ret);
	}

?>

<div class="page-header">
	<?php if ($admin): ?>
		<h3>Gérer les films</h3>		
	<?php else: ?>
		<h3>Liste des films</h3>
	<?php endif ?>
</div>


<?php echo $this->Form->create('Search',array('class' => 'form-search well')); ?>

<?php echo $this->Form->input('advanced',array('type' => 'hidden', 'value' => '0')); ?> 

<?php echo $this->Form->input('name',array('label' => 'Recherche ', 'placeholder' => 'Titre')); ?>

<?php echo $this->Html->link("Recherche avancée", '#', array('onclick' => 'toggleAdvancedSearch(); return false;')); ?>
<div id="AdvancedSearchDiv" class='hide'>
	<?php echo $this->Form->input('format',array('label' => 'Format ')); ?>
</div>

<?php echo $this->Form->end(array('label' => 'Rechercher',  'div'=> array('class' => 'hide', 'id' => 'SearchSubmit'))); ?>


<table style="width:100%;"><tbody><tr>
<td style="width:70%; vertical-align: top;">
<table class="table table-striped" id='VideoTable'>
	<thead>
		<th>Titre</th>
		<th>Format</th>
		<th>Genre</th>
		<?php if ($admin): ?>
			<th>Actions</th>	
		<?php endif ?>
		
	</thead>

	<?php //debug($videos) ?>

	<?php foreach ($videos as $k => $v): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($v['Video']['name']
				, array('action' => 'show', $v['Video']['id'])
				, array('class' => 'VideoLink', 'data-id' => $v['Video']['id'])
			);?>
		</td>

		<td><?php echo $v['Format']['name'] ?></td>

		<td><?php echo outputcsv($v['Category']); ?></td>

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

			</td>
			<td style="width:30%; height:600px; vertical-align:top;">
				<div class="well" id="PreviewDiv">
					<div align="center">
						<img id="PreviewCover" src="/videotheque/img/covers/jaquette_indisponible.png" style="max-width: 200px" id="CoverPreview" alt="">
					</div>
					<h4 id='PreviewName'></h4>
					<h4>Synopsis:</h4>
					<p id="PreviewSynopsis">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					<h4>Avec:</h4>
					<p id="PreviewCasting">Toto titi, machin truc, bidule chose.</p>
				</div>
			</td>
		</tr>
	</tbody>
</table>

<?php echo $this->Html->link(""
	, array('action' => 'ajaxPreview', 'controller' => 'videos', 'admin' => false)
	, array('style' => 'visibility: none;', 'id' => 'PreviewUrl')); ?>

<?php echo $this->Paginator->numbers() ?>
<?php echo $this->Html->script('index',array('inline' => false)); ?>
