<?php
App::import('Vendor','simple_html_dom');

class AllocineParserComponent extends Component {


	public function getHtml($id, $page){
		$url = '';

		switch ($page) {
			case 'general':
				$url = 'http://www.allocine.fr/film/fichefilm_gen_cfilm='.$id.'.html';
				break;
			
			case 'casting':
				$url = 'http://www.allocine.fr/film/fichefilm-'.$id.'/casting/';
				break;


			default:
				return null;
		}

		return file_get_html($url);
	}


    public function parse($id) {
		$ret = array();

		// Infos de l'onglet d'accueil de la fiche du film
		$html = $this->getHtml($id,'general');

		$ret['title'] = $html->find('div#title',0)->find('span',0)->innertext;
		//$html = $html->find('div.data_box',0);


		// Infos de la fiche casting
		$html = $this->getHtml($id,'casting');

		$director = $html->find('div.media_list_02',0)->find('li[itemscope]',0);
		$ret['director'] = $director->find('span[itemprop]',0)->innertext;

		$actors = $html->find('div.media_list_02',1)->find('li[itemscope]');	
		foreach ($actors as $key => $value) {
			$ret['Actors'][] = $value->find('span[itemprop]',0)->innertext;
		}
		
		debug($ret);
		return $ret;      
    }
}
?>