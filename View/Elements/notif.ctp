<div class=" alert <?php echo 'alert-'. (isset($type)? $type : 'success');?>">
	<button class="close" onclick="$(this).parent().hide()">&times;</button>
	<p> <?php echo $message ?> </p>

</div>