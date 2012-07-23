jQuery(function($){ // pour être sûr que jquery est chargé, etc.

	// TODO: affichage infos par là.
	$("#VideoTable").delegate('td','mouseover mouseleave', function(e) {
		if (e.type == 'mouseover') {
			$(this).parent().addClass("hover");
			$("colgroup").eq($(this).index()).addClass("hover");
			fillVideoPreview($('.hover').find('a')[0].getAttribute('data-id'));
		}
		else {
			$(this).parent().removeClass("hover");
			$("colgroup").eq($(this).index()).removeClass("hover");
			emptyVideoPreview();
		}
	});
});


function fillVideoPreview(video_id){
	console.log('displayVideoInfo: ' + video_id);
	$('#PreviewDiv').show();
}

function emptyVideoPreview(){
	$('#PreviewDiv').hide();
}
