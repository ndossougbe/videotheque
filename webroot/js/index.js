jQuery(function($){ // pour être sûr que jquery est chargé, etc.
	applyAdvancedSearchState($('#SearchAdvanced').val() == 1);		

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

function toggleAdvancedSearch () {
	if( $('#SearchAdvanced').val() == 1 ){
		$('#SearchAdvanced').val(0);
		applyAdvancedSearchState(false);		
	}else{
		$('#SearchAdvanced').val(1);
		applyAdvancedSearchState(true);		
	}
}

function applyAdvancedSearchState(advanced){
	if( advanced ){
		$('#AdvancedSearchDiv').removeClass('hide');
		$('#SearchSubmit').removeClass('almost_hide');
		$('#AdvancedSearchTrigger').html('Recherche avanc&eacutee [&#8211]');
		$('#SearchNameLabel').html('Titre');
		$('#SearchName').attr('placeholder','');
	}
	else{
		$('#AdvancedSearchDiv').addClass('hide');
		$('#SearchSubmit').addClass('almost_hide');
		$('#AdvancedSearchTrigger').html('Recherche avanc&eacutee [+]');  // &#8211: code pour un gros -
		$('#SearchNameLabel').html('Recherche');
		$('#SearchName').attr('placeholder','Titre');
	}
}

function fillVideoPreview(video_id){
	console.log('fillVideoPreview: ' + video_id);

	var query_url = $('#PreviewUrl').attr('href');
	console.log(query_url);
	$.get(query_url +'/'+ video_id, {}, function(data) {
		var video_preview = jQuery.parseJSON(data);
		console.log(video_preview);

		console.log($('#PreviewSynopsis'));
		$('#PreviewCover').attr('src',video_preview.cover);
		$('#PreviewName').html(video_preview.name);
		$('#PreviewSynopsis').html(video_preview.synopsis);
		$('#PreviewCasting').html(video_preview.casting);
		$('#PreviewDiv').removeClass('hide');
	});

}

function emptyVideoPreview(){
	$('#PreviewDiv').addClass('hide');
	// $('#PreviewCover').attr('src','/videotheque/img/covers/jaquette_indisponible.png');
	// $('#PreviewName').html('');
	// $('#PreviewSynopsis').html('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
	// $('#PreviewCasting').html('Toto titi, machin truc, bidule chose.');
}
