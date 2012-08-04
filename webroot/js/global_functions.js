
jQuery(function($){ // pour être sûr que jquery est chargé, etc.

    // Permet d'enlever le style erreur lorsqu'on essaie de corriger un champ
    $('.input.error input, .input.error textarea').focus(function(){
        $(this).parent().removeClass('error');
        $(this).parent().find('.error-message').remove();
    });

    $('.nav a').each(function(){
        if('http://' + window.location.hostname + $(this).attr('href') == window.location.href.split("#")[0]){
            console.log($(this))
            $(this).addClass('active');
            // TODO: remplacer le lien par du texte? juste changer le style?
        }
            
    });

});