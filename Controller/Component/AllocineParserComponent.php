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


		$html = $html->find('div.data_box',0);

		echo  iconv(mb_detect_encoding($html->find('ul',0)), "UTF-8//TRANSLIT//IGNORE", $html->find('ul',0));

		foreach( $html->find('li') as $k => $v){
			switch ($v->find('span',0)->innertext) {
				case 'Genre':
					foreach ($v->find('a') as $l => $w) {
						$ret['rating'][] = $w->innertext;
					}
					break;
				
				case 'Date de sortie ':	// Attention, il faut un espace à la fin de la chaine.
					$ret['datePublished'] = $v->find('span[itemprop=datePublished]',0)->innertext;
					$ret['duration'] = $v->find('span[itemprop=duration]',0)->innertext;
					break;

				case 'Nationalité':
					// Lien remplacé par un span quand on parse... wtf?
					$nationalityLink = $v->find('a|span.acLnk',0);
					echo 'lien: '.$nationalityLink;
					$ret['nationality'] = $nationalityLink->innertext;
					//$ret['nationality']['label'] = $nationalityLink->innertext;


					// Etape gourmande (Chargement d'une page supplémentaire) et pas indispensable.
					// TODO: enlever?
					//$countryPage = file_get_html('allocine.fr'.$nationalityLink->href);
					//$ret['nationality']['country'] = $countryPage->find('div.titlebar')->first_child->innertext;
					break;

				default:
					break;
			}
		}

		$ret['rating'] =  $html->find('span.note',0)->innertext;

		// Infos de la fiche casting
		$html = $this->getHtml($id,'casting');

		$director = $html->find('div.media_list_02',0)->find('li[itemscope]',0);
		$ret['director'] = $director->find('span[itemprop]',0)->innertext;

		$actors = $html->find('div.media_list_02',1)->find('li[itemscope]');	
		foreach ($actors as $key => $value) {
			$ret['actors'][] = $value->find('span[itemprop]',0)->innertext;
		}
		
		return $ret;      
    }
}
?>