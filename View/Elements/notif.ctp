<div class="notif <?php echo isset($type)? $type : 'success';?>">
	<div class="close"><a href="#" onclick="$(this).parent().parent().hide()">x</a></div>
	<p> <?php echo $message ?> </p>

</div>