// jQuery(function($){ // pour être sûr que jquery est chargé, etc.

// 	// Permet d'enlever le style erreur lorsqu'on essaie de corriger un champ
// 	$('.input.error input, .input.error textarea').focus(function(){
// 		$(this).parent().removeClass('error');
// 		$(this).parent().find('.error-message').remove();
// 	});

// });

window.onbeforeunload = verifJaquette;

function verifJaquette(){
	//"Verif Jaquette todo"
	// n'est pas une url et a changé mais pas de sauvegarde => on supprime la copie de la jaquette sur le serveur.
}

function trim (str){
	return str.replace(/^\s+/g,'').replace(/\s+$/g,'');
} 


function afficherNouvelleFenetre(str) {
	var WinPrint = window.open('', '', 'width=450,height=600,toolbar=0,scrollbars=0,status=0');
	WinPrint.document.open("text/html", "replace");
	WinPrint.document.write('<html><head><title>Résultats de la recheche: Allociné</title></head><body>');
	WinPrint.document.write(str);
	WinPrint.document.write('</body></html>');
	WinPrint.document.close();
	WinPrint.focus();
}

function popup(url){
	newwindow=window.open(url,'Insérer une image','height=500,width=550');
	if (window.focus) newwindow.focus();
	return false;
}


function actualiserAffiche(url){
	var src;
	if(url.match(/^http:\/\/*/g)) src = url;
	else src = '/videotheque/img/' + url;
	document.getElementById('CoverPreview').src = src;
	document.getElementById('VideoCover').value = url;
}








function getElementByAttr(e,attr,value)
{
	var tab = [];
	if (e.getAttribute && e.getAttribute(attr)==value)
	  tab.push(e);
 
	var n = e.firstChild;
	if (n==null || typeof n=='undefined') return tab;
	do
	{
	  var tab2 = getElementByAttr(n,attr,value);
		tab = tab.concat(tab2);
	}while((n = n.nextSibling)!=null)
	return tab;
}