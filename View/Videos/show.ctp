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
				
			<dt>Format</dt>
			<dd><?php echo $video['format']; ?></dd>			
			<dt>Acteurs</dt>
			<dd><?php echo $video['actors']; ?> </dd>
			<dt>Réalisateur</dt>
			<dd><?php echo $video['director']; ?>	</dd>
			<dt>Genres</dt>
			<dd><?php echo $video['categories']; ?> </dd>
			<dt>Nationalité</dt>
			<dd><?php echo $video['nationality']; ?>	</dd>
			<dt>Note</dt>
			<dd><?php echo $video['rating']; ?>	</dd>
			<dt>Date de sortie</dt>
			<dd><?php echo $video['releasedate']; ?> </dd>
			<dt>Durée</dt>
			<dd><?php echo $video['duration']; ?></dd>
			</dl>

			<?php echo $this->Html->link("Plus d'infos (lien externe)", $video['url']); ?>
		</div>
	</div>
	<p style='margin-top: 20px'><?php echo $video['synopsis'] ?></p>
</div>


