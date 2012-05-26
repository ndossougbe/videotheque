<div class=" alert <?php echo 'alert-'. (isset($type)? $type : 'success');?>">
	<a class="close" href="#" onclick="$(this).parent().hide()">x</a>
	<p> <?php echo $message ?> </p>

</div>