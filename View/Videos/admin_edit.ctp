<div id="form_div">
	<div class="page-header">
		<h1>Editer une vidéo</h1>
	</div>

	<?php echo $this->Form->create('Video',array('default' => false,'class' => 'form-search well', 'onsubmit' => 'searchAction();')); ?>
	<input type='text' class='input-medium search-query' id='VideoSearch' placeholder='Titre de film'/>
	<?php echo $this->Html->link(
		'<i class="icon-search"></i> Rechercher en ligne'
		, array('action' => 'ajaxSearch')
		, array(
			'id'            => 'SearchBtn'
			, 'class'         => 'btn'
			, 'escape'        => false
			, 'onclick'				=> 'return searchAction()'
		)
	);?>
	<?php echo $this->Form->end(); ?>

	<?php //debug($this->request->data) ?>
	<?php echo $this->Form->create('Video',array('class' => 'form-horizontal well')); ?>
	<?php echo $this->Form->input('id'); ?> 
	<div class="row">
		<div class='span6'>
			<!-- Infos générales	 -->
			<?php echo $this->Form->input('name', array('label' => 'Titre') ); ?>
			
			<?php echo $this->Form->input('original_title', array('label' => 'Titre original') ); ?>

			<?php echo $this->Form->input('url', array('label' => 'Lien')); ?>

			<?php echo $this->Form->input('format_id'); ?>

			<?php echo $this->Form->input('Video.Acteurs',array(
				'type' 					=> 'textarea',
				'rows' 					=> 2,
				'data-provide' 	=> 'typeahead',
				'data-source' 	=> $lstActors,
				'data-mode' 		=> 'multiple',
				'data-items'		=> '10'
			)); ?> 

			<?php echo $this->Form->input('Director.name', array(
				'label' => 'Réalisateur',
				'autocomplete' => 'off',
				'data-provide' 	=> 'typeahead',
				'data-source' 	=> $lstActors
			)); ?>	

			<?php echo $this->Form->input('Video.Categories',array(
				'type'          => 'textarea',
				'rows'          => 2,
				'data-provide' 	=> 'typeahead',
				'data-source' 	=> $lstCategories,
				'data-mode' 	=> 'multiple',
				'data-items'	=> '10'
			)); ?> 

			<?php echo $this->Form->input('Country.nationality', array('label' => 'Nationalité')); ?>	

			<?php echo $this->Form->input('rating', array('label' => 'Note (sur 20)', 'type' => 'text')); ?>	

			<?php echo $this->Form->input('releasedate',array(
				'label'         => "Date de sortie",
				'dateFormat'	=> "DMY",
				'class'			=> "defaultWidth"
			)); ?> 

			<?php echo $this->Form->input('duration',array(
				'label'         => "Durée",
				'class'			=> "defaultWidth",
				'timeFormat'    => "24"
			)); ?> 
		</div>

		<!-- Jaquette, etc. -->
		<div class='span4'>
			<?php 
			if (isset($this->request->data['Video'])){
				$url = $this->request->data['Video']['cover'];
				$id = $this->request->data['Video']['id'];
			}else{
				$url = 'covers/jaquette_indisponible.png';
				$id = "";
			}
			?>
			<div align="center">
				<?php echo $this->Html->image($url ,array(
					'style' => 'max-width: 200px',
					'id'	=> 'CoverPreview'
				)); ?>
			<div>

			<?php echo $this->Form->input('Video.cover', array(
					'label' => 'Jaquette'
				, 'placeholder' => 'lien vers l\'image'
				, 'onblur' => 'updateCover()' 
			)); ?>	

			<!--<?php echo $this->Html->link(
				'Importer une jaquette'
				, array('action' => 'uploadCover')
				, array(
						'id'            => 'UploadCoverBtn'
					, 'class'         => 'btn'
					, 'onclick'				=> 'return uploadCoverAction()'
				)
			);?>-->


				</div>
			</div>
			<?php //echo $this->Form->hidden('cover'); ?>			

			<?php echo $this->Form->label('synopsis', 'Synopsis', array('style' => 'display: block')); ?>	
			<?php echo $this->Form->input('synopsis', array('label' => false, 'style' => 'width: 100%')); ?>	
		</div>
	</div>

	<?php echo $this->Form->end( "Enregistrer", array('class' => 'btn') ); ?>
</div>


<!-- Modals -->
<div class="modal hide" id="search_modal">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">&times;</button>
		<h3>Résultats de la recherche</h3>
	</div>
	<div class="modal-body" id="SearchResults"></div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Fermer</a>
	</div>
</div>

<div id='UploadCoverModal' class='modal hide'>
	<div class="modal-header">
		<button class="close" data-dismiss="modal">&times;</button>
			<h3>Importer une jaquette</h3>
	</div>
	<div class="modal-body" id="UploadCoverContentDiv"></div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Fermer</a>
		</div>
</div>

<!-- JavaScript -->
<?php echo $this->Html->script('bootstrap-modal',array('inline' => false)); ?>
<?php echo $this->Html->script('bootstrap-typeahead',array('inline' => false)); ?>

<?php echo $this->Html->script('admin',array('inline' => false)); ?>
<?php echo $this->Html->script('admin_edit',array('inline' => false)); ?>