<script type="text/javascript">
function bleh(){
	var win = window.dialogArguments || opener || parent || top;
	win.actualiserAffiche("<?php echo $url ?>");
	self.close();
}

window.onload = bleh; 
</script>