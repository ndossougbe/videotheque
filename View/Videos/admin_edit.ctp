<div id="form_div">
	<div class="page-header">
		<h1>Editer une page</h1>
	</div>
	<?php echo $this->Form->create('Video'); ?>
		<?php echo $this->Form->input('id'); ?> 
		<?php echo $this->Form->input('name', array('label' => 'Titre', 
			'div' => array('style' => 'display: inline;')
		)); ?>
		<input type="button" style="width: 100px; font-size: 100%;" onclick="rechercheAllocine( <?php echo $webroot ?> );" value="Chercher sur Allocine" >
		<?php echo $this->Form->input('url', array('label' => 'Lien')); ?>

		<?php echo $this->Html->image($this->request->data['Video']['cover'],array(
			'style' => 'max-width: 200px',
			'id'	=> 'affiche'
		)); ?> <br />
		
		<a href="#", onclick="return popup('<?php echo $this->Html->url(array(
			'action' => 'addimg',
			'controller' => 'videos',
			$this->request->data['Video']['id']
		), true); ?>');">Insérer une image</a>

		<?php echo $this->Form->hidden('cover'); ?>

		<?php echo $this->Form->input('format_id'); ?>


		<?php //echo $this->Form->input('format', array('label' => 'Format')); ?>
		<?php echo $this->Form->input('size', array('label' => 'Taille')); ?>
	<?php echo $this->Form->end('Envoyer'); ?>
</div>
<div id="rech_div" style="display: none;">
	<!-- TODO: Popin? -->
	<iframe src="" width="100%" height="800" name="rechFrame" id="rechFrame"></iframe>
</div>

<!-- JavaScript -->
<?php echo $this->Html->script('admin',array('inline' => false)); ?>