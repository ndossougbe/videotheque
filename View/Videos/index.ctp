<h1> Liste des films </h1>
<?php foreach($videos as $v): $v = current($v); ?>
		<!-- Voir Model.Video.afterFind-->
		<?php echo $this->Html->link($v['name'],$v['link']);?><br />
<?php endforeach ?>
