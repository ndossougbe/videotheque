<div id="form_div">
	<div class="page-header">
		<h1>Editer une vidéo</h1>
	</div>

	<?php debug($this->request->data) ?>
	<?php echo $this->Form->create('Video',array('class' => 'form-horizontal well')); ?>
		<?php echo $this->Form->input('id'); ?> 

		<table>
			<tr>
				<td style="width:60%;">
					<!-- Infos générales	 -->
					<div class="control-group">
						<?php echo $this->Form->input('name', array('label' => 'Titre', 'div' => array('style' => 'display: inline;')) ); ?>
						<?php echo $this->Html->link(
							"<i class='icon-search'></i> Chercher sur Allociné", 
							array('action' => 'ajaxAllocineSearch'),
							array(
								'id'            => "SearchBtn",
								'class'         => 'btn', 
								'escape'        => false,
								'data-toggle'   => "modal",
							)
						);?>
					</div>

					<?php echo $this->Form->input('url', array('label' => 'Lien')); ?>

					<?php echo $this->Form->input('format_id'); ?>

					<?php echo $this->Form->input('Video.Actors',array(
						'type' 					=> 'textarea',
						'rows' 					=> 2,
						'data-provide' 	=> 'typeahead',
						'data-source' 	=> $this->request->data['lstActeurs'],
						'data-mode' 		=> 'multiple',
						'data-items'		=> '10'
					)); ?> 

					<?php echo $this->Form->input('director', array(
						'label' => 'Réalisateur',
						'data-provide' 	=> 'typeahead',
						'data-source' 	=> $this->request->data['lstActeurs']
					)); ?>	

					<?php echo $this->Form->input('Video.Categories',array(
						'type'          => 'textarea',
						'rows'          => 2,
						'data-provide' 	=> 'typeahead',
						'data-source' 	=> $this->request->data['lstCategories'],
						'data-mode' 	=> 'multiple',
						'data-items'	=> '10'
					)); ?> 

					<?php echo $this->Form->input('nationality', array('label' => 'Nationalité')); ?>	

					<?php echo $this->Form->input('rating', array('label' => 'Note', 'type' => 'text')); ?>	

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


				</td>

				<!-- Jaquette, etc. -->
				<td style="width:40%;">
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
							<a href="#", onclick="return popup('<?php echo $this->Html->url(array(
								'action' => 'addimg',
								'controller' => 'videos',
								$id
							), true); ?>');">Insérer une image</a>
						</div>
					</div>
					<?php echo $this->Form->hidden('cover'); ?>			

					<?php echo $this->Form->label('synopsis', 'Synopsis', array('style' => 'display: block')); ?>	
					<?php echo $this->Form->input('synopsis', array('label' => false, 'style' => 'width: 100%')); ?>	

				</td>
			</tr>
		</table>

		<?php echo $this->Form->submit("Enregistrer", array('class' => 'btn') )?>

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

	<?php echo $this->Form->end(); ?>
</div>

<!-- JavaScript -->
<?php echo $this->Html->script('bootstrap-modal',array('inline' => false)); ?>
<?php echo $this->Html->script('bootstrap-typeahead',array('inline' => false)); ?>

<?php echo $this->Html->script('admin',array('inline' => false)); ?>
<?php echo $this->Html->script('admin_edit',array('inline' => false)); ?>