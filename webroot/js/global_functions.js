function clearCurrentLink(node){
    if(node == null){
		node = document;
    }
    var links = node.getElementsByTagName("A");
    for(var i = 0; i < links.length; i++){
		if(links[i].href == window.location.href.split("#")[0]){
            //console.log(links[i]);
            links[i].parentNode.className = "active";
            //removeNode(links[i]);
        }
			
    }
}

function removeNode(n){
    if(n.hasChildNodes())
        for(var i=0;i<n.childNodes.length;i++)
            n.parentNode.insertBefore(n.childNodes[i].cloneNode(true),n);
    n.parentNode.removeChild(n);
}


window.onload = clearCurrentLink(document.getElementById("menu"));