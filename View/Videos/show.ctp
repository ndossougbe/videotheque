<?php $this->set('title_for_layout',$video['name'])?>

<div class = "page-header">
	<h1><?php echo $video['name']; ?></h1>

	<div class="row">
		<div class="span3">
			<?php 
			if (isset($video['cover']) && $video['cover'] != null){
				$url = $video['cover'];
			}else{
				$url = 'covers/jaquette_indisponible.png';
			}
			?>
				<?php echo $this->Html->image($url ,array(
					'style' => 'max-width: 300px'
				)); ?>
		</div>
		<div class="span6" style='float: left'>


			<dl class='dl-horizontal' >
				<?php if ($video['original_title'] && $video['original_title'] != $video['name']): ?>
					<dt>Titre original</dt>
					<dd><?php echo $video['original_title']; ?></dd>			
				<?php endif ?>

				<?php if ($video['format']): ?>
					<dt>Format</dt>
					<dd><?php echo $video['format']; ?></dd>			
				<?php endif ?>
				<?php if ($video['actors']): ?>
					<dt>Acteurs</dt>
					<dd><?php echo $video['actors']; ?> </dd>
				<?php endif ?>
				<?php if ($video['director']): ?>
					<dt>Réalisateur</dt>
					<dd><?php echo $video['director']; ?>	</dd>
				<?php endif ?>
				<?php if ($video['categories']): ?>
					<dt>Genres</dt>
					<dd><?php echo $video['categories']; ?> </dd>
				<?php endif ?>
				<?php if ($video['nationality']): ?>
					<dt>Nationalité</dt>
					<dd><?php echo $video['nationality']; ?>	</dd>
				<?php endif ?>
				<?php if ($video['rating']): ?>
					<dt>Note</dt>
					<dd><?php echo $video['rating']; ?>	</dd>
				<?php endif ?>
				<?php if ($video['releasedate']): ?>
					<dt>Date de sortie</dt>
					<dd><?php echo $video['releasedate']; ?> </dd>
				<?php endif ?>
				<?php if ($video['duration']): ?>
					<dt>Durée</dt>
					<dd><?php echo $video['duration']; ?></dd>
				<?php endif ?>
			</dl>

			<?php if ($video['url']): ?>
				<?php echo $this->Html->link("Plus d'infos (lien externe)", $video['url']); ?>
			<?php endif ?>
		</div>
	</div>
	<p style='margin-top: 20px'><?php echo $video['synopsis'] ?></p>
</div>


