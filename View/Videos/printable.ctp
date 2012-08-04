<head>
<style type="text/css">
table{
	font-size: small;
}
</style>
</head>

<?php $nbcolumns = 3; ?>
<table style='width:100%'>
	<thead>
		<?php for($k = 0; $k < $nbcolumns; $k++): ?>
			<td style='width: <?php echo 100/$nbcolumns?>%'/>	
		<?php endfor ?>
	</thead>
<?php 
	$i = 0; 
	foreach ($videos as $v){
		if($i == 0)echo '<tr>';
		echo '<td>'.$v.'</td>';
		if($i == $nbcolumns-1)echo '</tr>';
		$i = ($i+1)%$nbcolumns;
	}
?>
</table>