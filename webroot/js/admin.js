jQuery(function($){ // pour être sûr que jquery est chargé, etc.

	// Permet d'enlever le style erreur lorsqu'on essaie de corriger un champ
	$('.input.error input, .input.error textarea').focus(function(){
		$(this).parent().removeClass('error');
		$(this).parent().find('.error-message').remove();
	});

});

window.onbeforeunload = verifJaquette;

function verifJaquette(){
	//"Verif Jaquette todo"
}

function infosLien(url){
	document.getElementById('VideoUrl').value = 'http://allocine.fr' + url;
	retour();
	return false; // Pour éviter de suivre les liens.
}


function trim (str){
	return str.replace(/^\s+/g,'').replace(/\s+$/g,'');
} 

function retour(){
	document.getElementById('form_div').style.display="";
	document.getElementById('rech_div').style.display="none";
	document.getElementById('rechFrame').src = "";
	
}


function rechercheAllocine(webroot){
	
	var toFind = document.getElementById('VideoName').value;
	if(toFind != null && (toFind = toFind.trim()) != ""){
		// %2B = échappement du caractère '+'
		toFind = toFind.replace(/ /g,'%2B'); // On remplace les espaces par '+'
		var uri = webroot+"scrap.php?q="+toFind;

		document.getElementById('form_div').style.display="none";

		/*var xhr = new XMLHttpRequest();
	    xhr.open("GET", uri, true);
	    xhr.send();
	    for (i=1;i<10000;i++){};
	    //var xmlDocument = xhr.responseXML;

		document.getElementById('rech_div').innerHTML = xhr.responseText;*/
		document.getElementById('rechFrame').src = uri;
		document.getElementById('rech_div').style.display="";
		/*$.get(uri, function(ret){
			//$("div#content").html(xml);
			// filtrage
			afficherNouvelleFenetre(ret);
		});*/
	}
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
	alert(url);
	var src;
	if(url.match(/^http:\/\/*/g)) src = url;
	else src = '/videotheque/img/' + url;
	document.getElementById('affiche').src = src;
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