<div id="form_div">
	<div class="page-header">
		<h1>Editer une page</h1>
	</div>
	<?php echo debug($this->request->data) ?>
	<?php echo $this->Form->create('Video',array('class' => 'form-horizontal well')); ?>
		<?php echo $this->Form->input('id'); ?> 

		<table>
			<tr>
				<td style="width:60%;">
					<!-- Infos générales	 -->
					<div class="control-group">
						<?php echo $this->Form->input('name', array('label' => 'Titre', 'div' => array('style' => 'display: inline;')) ); ?>
						<a class="btn" data-toggle="modal" href="#search_modal" onclick="rechercheAllocine('<?php echo $webroot; ?>');">
							<i class='icon-search'></i> Chercher sur Allociné
						</a>
					</div>

					<?php echo $this->Form->input('url', array('label' => 'Lien')); ?>

					<?php echo $this->Form->input('format_id'); ?>

					<?php echo $this->Form->input('size', array('label' => 'Taille', 'type' => 'text')); ?>	

					<?php echo $this->Form->input('Video.Acteurs',array(
						'type' 					=> 'textarea',
						'rows' 					=> 2,
						'data-provide' 	=> 'typeahead',
						'data-source' 	=> $this->request->data['lstActeurs'],
						'data-mode' 		=> 'multiple',
						'data-items'		=> '10'
					)); ?> 
				</td>

				<!-- Jaquette, etc. -->
				<td style="width:40%; padding-left: 10%;">
					<?php 
						if (isset($this->request->data['Video'])){
							$url = $this->request->data['Video']['cover'];
							$id = $this->request->data['Video']['id'];
						}else{
							$url = 'covers/jaquette_indisponible.png';
							$id = "";
						}
					?>
					<?php echo $this->Html->image($url ,array(
						'style' => 'max-width: 200px',
						'id'	=> 'affiche'
					)); ?>
					<div>
						<a href="#", onclick="return popup('<?php echo $this->Html->url(array(
							'action' => 'addimg',
							'controller' => 'videos',
							$id
						), true); ?>');">Insérer une image</a>
					</div>
					<?php echo $this->Form->hidden('cover'); ?>			

				</td>
			</tr>
		</table>

		<?php echo $this->Form->submit("Enregistrer", array('class' => 'btn') )?>

		<div class="modal hide" id="search_modal">
			<div class="modal-header">
			    <button class="close" data-dismiss="modal">&times;</button>
			    <h3>Résultats de la recherche</h3>
			  </div>
			  <div class="modal-body" id="resultats"></div>
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