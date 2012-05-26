
<?php 
if($src){
	echo "<h3>Jaquette actuelle</h3>";
	echo $this->Html->image($src,array(
		'style' => 'max-width: 200px'
	));
}
 ?>

<h3>Nouvelle jaquette</h3>

<h4>Depuis cette machine</h4>
<?php echo $this->Form->create(false,array('type' => 'file')); ?>
	<?php echo $this->Form->input('file',array('label' => "Image (format png/jpg)", 'type' => 'file')); ?> 
<?php echo $this->Form->end('Insérer'); ?>

<h4>Depuis le web</h4>
<?php echo $this->Form->create(false); ?>
	<?php echo $this->Form->input('url',array('label' => "URL de l'image")); ?> 
<?php echo $this->Form->end('Insérer'); ?>