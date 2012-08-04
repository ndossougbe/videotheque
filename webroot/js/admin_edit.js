jQuery(function($){ // pour être sûr que jquery est chargé, etc.


	//$('#SearchBtn').on('click', searchAction);
});

function searchAction(){
	if( !$('#VideoSearch').val() ) return false;
	console.log('Search with string: ' + $('#VideoSearch').val());
	$('#search_modal').modal('show'); // Cachée dans linkSelected_Action
	$('#SearchResults').html(gifLoader());
	
	$.get($('#SearchBtn').attr('href')+'/'+ $('#VideoSearch').val(), {}, function(data) {
		console.log($('#SearchResults'));
		$('#SearchResults').html(data);
	});
	return false;
}

function uploadCoverAction(){
	// console.log('Search with string: ' + $('#VideoSearch').val());
	console.log($('#UploadCoverBtn').attr('href'));
	$.get($('#UploadCoverBtn').attr('href'), {}, function(data) {
		console.log(data);
		$('#UploadCoverContentDiv').html(data);
	});
	$('#UploadCoverModal').modal('show'); // Cachée dans linkSelected_Action
	return false;
}

function updateCover(){
	console.log($('#CoverPreview'));
	console.log($('#VideoCover').val());
	$('#CoverPreview').attr('src',$('#VideoCover').val());
}

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
/////////////////////////////////////

// function uploadValidation(){
//     var file = this.files[0];
//     name = file.name;
//     size = file.size;
//     type = file.type;
//     //your validation
// }
// function uploadFile(targetUrl){
//     var formData = new FormData($('form')[0]);
//     $.ajax({
//         url: targetUrl,  //server script to process data
//         type: 'POST',
//         xhr: function() {  // custom xhr
//             myXhr = $.ajaxSettings.xhr();
//             if(myXhr.upload){ // check if upload property exists
//                 myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // for handling the progress of the upload
//             }
//             return myXhr;
//         },
//         //Ajax events
//         beforeSend: beforeSendHandler,
//         success: completeHandler,
//         error: errorHandler,
//         // Form data
//         data: formData,
//         //Options to tell JQuery not to process data or worry about content-type
//         cache: false,
//         contentType: false,
//         processData: false
//     });
// });


// function progressHandlingFunction(e){
//     if(e.lengthComputable){
//     		$('progress').show();
//         $('progress').attr({value:e.loaded,max:e.total});
//     }
// }
