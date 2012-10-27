jQuery(function($){ // pour être sûr que jquery est chargé, etc.
	/* Recherche avancée *******************************************************/
	applyAdvancedSearchState($('#SearchAdvanced').val() == 1);		

	/* Affichage du détail des films *******************************************/
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

	/* Scroll de la div de détail des films ************************************/
	// Récupération de la position initiale. Si auto alors on prend 0.
	var top = $('#PreviewDivWrapper').offset().top - parseFloat($('#PreviewDivWrapper').css('margin-top').replace(/auto/, 0));
	var left = $('#PreviewDivWrapper').offset().left - parseFloat($('#PreviewDivWrapper').css('margin-left').replace(/auto/, 0));
  $(window).scroll(function (event) {
    // Récupération de la position de scroll actuelle
    var y = $(this).scrollTop();

    // Test si on est sous la div
    if (y >= top) {
      // Oui, on ajoute la classe fixed
      $('#PreviewDivWrapper').addClass('fixed');
      $('#PreviewDivWrapper').css('left',left);
    } else {
      // Non, on l'enlève
      $('#PreviewDivWrapper').removeClass('fixed');
      $('#PreviewDivWrapper').css('left','');	      
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
	// console.log('fillVideoPreview: ' + video_id);

	var query_url = $('#PreviewUrl').attr('href');
	// console.log(query_url);
	$.get(query_url +'/'+ video_id, {}, function(data) {
		var video_preview = jQuery.parseJSON(data);
		//console.log(video_preview);

		var video_title = video_preview.name;
		if (video_preview.original_title && video_preview.name != video_preview.original_title){
			video_title += " (" + video_preview.original_title + ")";
		}

		// console.log($('#PreviewSynopsis'));
		$('#PreviewCover').attr('src',video_preview.cover);
		$('#PreviewName').html(video_title);
		$('#PreviewSynopsis').html(video_preview.synopsis);
		$('#PreviewCasting').html(video_preview.casting);
		$('#PreviewDiv').removeClass('hide');
	});

}

function emptyVideoPreview(){
	$('#PreviewDiv').addClass('hide');
}
