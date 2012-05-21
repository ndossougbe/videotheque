<h3>Insérer l'image</h3>

<img src=" <?php echo $url; ?> " style = "max-width: 200px;">

<?php echo $this->Form->create('Media'); ?>
	<?php echo $this->Form->input('alt',array('label' => "Description de l'image", 'value' => $alt)); ?> 
	<?php echo $this->Form->input('src',array('label' => "Chemin de l'image" , 'value' => $url)); ?> 

	<!-- Class utilisé pour les select, radio, etc.
	Type par défaut: select. Pour radio, il faut remplacer 'label' par 'legend -->'
	<?php echo $this->Form->input('class',array('legend' => "Alignement", 'options' => array(
		"alignLeft" => "Aligner à gauche",
		"alignRight" => "Aligner à droite"
	), 'type' => 'radio')) ;?> 
<?php echo $this->Form->end('Ajouter'); ?>