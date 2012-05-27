<div id="form_div">
	<div class="page-header">
		<h1>Editer une page</h1>
	</div>
	<?php echo $this->Form->create('Video',array('class' => 'form-horizontal well')); ?>
		<?php echo $this->Form->input('id'); ?> 

		<table>
			<tr>
				<td style="width:60%;">
					<!-- Infos générales	 -->
					<div class="control-group">
						<?php echo $this->Form->input('name', array('label' => 'Titre', 'div' => array('style' => 'display: inline;')) ); ?>
						<?php echo $this->Html->link(" <i class='icon-search'></i> Chercher sur Allociné", "#", array(
							'onclick' => "rechercheAllocine(".$webroot." ); return false;",
							'class' => 'btn',
							'escape' => false
						)); ?>
					</div>

					<?php echo $this->Form->input('url', array('label' => 'Lien')); ?>

					<?php echo $this->Form->input('format_id'); ?>

					<?php echo $this->Form->input('size', array('label' => 'Taille', 'type' => 'text')); ?>	

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

		<?php echo  $this->Form->submit("Enregistrer", array('class' => 'btn') )?>

	<?php echo $this->Form->end(); ?>
</div>

<div id="rech_div" style="display: none;">
	<!-- TODO: Popin? -->
	<iframe src="" width="100%" height="800" name="rechFrame" id="rechFrame"></iframe>
</div>

<!-- JavaScript -->
<?php echo $this->Html->script('admin',array('inline' => false)); ?>