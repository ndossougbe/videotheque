jQuery(function($){ // pour être sûr que jquery est chargé, etc.

	$('#SearchBtn').on('click', function(){
		console.log('Search with string: ' + $('#VideoName').val());
		$('#search_modal').modal('show'); // Cachée dans linkSelected_Action
		$('#SearchResults').html(gifLoader());
		
		$.get($(this).attr('href')+'/'+ $('#VideoName').val(), {}, function(data) {
			console.log($('#SearchResults'));
			$('#SearchResults').html(data);
		});
		return false;
	});
});

function gifLoader(){
	return '<div align="center"><img src="/videotheque/img/ajax-loader.gif" style="width:100px;"></div>';
}

function videoLinkSelected(videoUrl){
	$('#VideoUrl').val(videoUrl);
	$('#SearchResults').html(gifLoader());
	var id_video = videoUrl.match(/cfilm=((\d*))\.html/)[1];
	console.log("idvideo: " + id_video);
	$.get('/videotheque/admin/videos/ajaxParse/'+ id_video, {}, function(data) {
		loadFields(data);
		$('#search_modal').modal('hide');
	});
	return false;
}

function loadFields(videoInfo){
	console.log('loadFields');
	console.log(videoInfo);
	var infoJSON = jQuery.parseJSON(videoInfo);
	console.log("loadFields");
	console.log(infoJSON);
	console.log(infoJSON.title);

	var field;
	for (var fieldName in infoJSON){
		if( infoJSON.hasOwnProperty(fieldName)){
			field = $('#'+fieldName);
			if(field != null) field.val(infoJSON[fieldName]);
		}
	}

	$('#CoverPreview').attr('src', infoJSON.VideoCover);
}

