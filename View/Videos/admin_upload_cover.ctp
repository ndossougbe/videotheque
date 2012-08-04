<h4>Depuis ma machine</h4>
<?php echo $this->Form->create(false,array('type' => 'file', 'class' => 'well', 'default'=>false)); ?>
	<?php echo $this->Form->input('file',array('label' => "Image (format png/jpg)", 'type' => 'file', 'onchange' => 'uploadValidation()')); ?> 
<?php echo $this->Form->end(array('label' => 'Importer', 'div' => false, 'onclick' => 'uploadFile("/videotheque/admin/videos/uploadCover"); return false;')); ?>
<progress class='hide'></progress>

<h4>Depuis le Web</h4>
<?php echo $this->Form->create(false, array('class' => 'well')); ?>
	<?php echo $this->Form->input('url',array('label' => "URL de l'image")); ?> 
<?php echo $this->Form->end(array('label' => 'Importer','div' => false)); ?>