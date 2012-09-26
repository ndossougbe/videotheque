<?php foreach ($results as $key => $movie): ?>
<?php //debug($movie) ?>

<div class="searchResult">
	<div class="movie poster">
		<img src="http://cf2.imgobject.com/t/p/w185<?php echo $movie['poster_path']?>" alt="Jaquette <?php echo $movie['title']?>">
	</div>
	<div class="movie info">
		<p>
		<h5><?php echo $movie['title']?></h5>
			<ul>
				<?php if ($movie['original_title'] != $movie['title']): ?>
					<li>Titre original: <?php echo $movie['original_title']?></li>
				<?php endif ?> 
				<li>Date de sortie: <?php echo $movie['release_date']?></li>
			</ul>
		<a href="#" class="btn" onclick="videoSelected(<?php echo $movie['id']?>); return false">Sélectionner</a>
		</p>
	</div>
</div>


<?php endforeach ?>
