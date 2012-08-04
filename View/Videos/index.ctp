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


<?php echo $this->Form->create('Search',array('class' => 'form-search well')); ?>
<?php echo $this->Form->input('advanced',array('type' => 'hidden', 'value' => $advanced)); ?> 

<?php echo $this->Html->link("Recherche avancée [+]", '#', array(
	'onclick'    => 'toggleAdvancedSearch(); return false;'
	, 'style'    => 'float: right;'
	, 'tabindex' => -1
	, 'id'       => 'AdvancedSearchTrigger'
	)); ?>

<?php echo $this->Form->input('name',array(
		'label' => array('text' => 'Recherche ', 'id' => 'SearchNameLabel')
	, 'placeholder' => 'Titre'
	, 'value' => $name
	)); ?>
	
	<div id="AdvancedSearchDiv" class='hide'>
		<?php echo $this->Form->input('format',array('label' => 'Format', 'value' => $format)); ?>
		<?php echo $this->Form->input('category',array('label' => 'Genre', 'value' => $category)); ?>
		<?php echo $this->Form->input('actor', array(
			'label'         => 'Acteur'
			, 'type'          => 'text'
			, 'autocomplete'  => 'off'
			, 'data-provide' 	=> 'typeahead'
			, 'data-source' 	=> $lstActors
			, 'value' => $actor
			)); ?>

	</div>

<?php echo $this->Html->link("Version imprimable", '#', array(
	  'style'    => 'float: right;'
	, 'tabindex' => -1
	, 'onclick'  => '$("#SearchPrintable").val(1); $("form:first").submit();'
	)); ?>

	<?php echo $this->Form->input('printable',array('type' => "hidden")); ?> 

<?php echo $this->Form->end(array('label' => 'Rechercher',  'div'=> array('class' => 'almost_hide', 'id' => 'SearchSubmit'))); ?>

<?php echo $this->Paginator->numbers() ?>
<div class="row">
	<div class="span8">
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

			<td><?php echo $v['Video']['categories'] ?></td>

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
</div>

<div class="span4" id='truc'>
	<div class="well hide" id="PreviewDiv">
		<div align="center">
			<img id="PreviewCover" style="max-width: 200px" id="CoverPreview">
		</div>
		<h4 id='PreviewName'></h4>
		<h4>Synopsis:</h4>
		<p id="PreviewSynopsis"></p>
			<h4>Avec:</h4>
			<p id="PreviewCasting"></p>
		</div>
	</div>
</div>

<?php echo $this->Html->link(""
	, array('action' => 'ajaxPreview', 'controller' => 'videos', 'admin' => false)
	, array('style' => 'visibility: none;', 'id' => 'PreviewUrl')); 
?>

<?php echo $this->Paginator->numbers() ?>

<?php echo $this->Html->script('bootstrap-typeahead',array('inline' => false)); ?>
<?php echo $this->Html->script('index',array('inline' => false)); ?>

