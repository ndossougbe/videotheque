<?php
include('simple_html_dom.php');

$q = $_GET["q"];
// get DOM from URL or file
$html = file_get_html("http://www.allocine.fr/recherche/?q=".$q);
$ret = $html->find('div.vmargin10t',0);
foreach($ret->find('a') as $a)
    $a->onclick = "top.infosLien('".$a->href."');";
echo '<p><input type="button" onclick="top.retour();" value="Retour"/></p>';
echo $ret;

?>