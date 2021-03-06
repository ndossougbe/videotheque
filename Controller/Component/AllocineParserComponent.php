<?php
App::import('Vendor','simple_html_dom');

class AllocineParserComponent extends Component {
	private $fieldNames = array(
			'title'        => 'VideoName',
			'actors'       => 'VideoActeurs',
			'director'     => 'DirectorName',
			'genre'        => 'VideoCategories',
			'nationality'  => 'CountryNationality',
			'datePublished'=> 'VideoReleasedate',
			'duration'     => 'VideoDuration',
			'rating'       => 'VideoRating',
			'description'  => 'VideoSynopsis',
			'poster'       => 'VideoCover'
		);


	public function getHtml($query, $page){
		$url = '';

		switch ($page) {
			case 'general':
				$url = 'http://www.allocine.fr/film/fichefilm_gen_cfilm='.$query.'.html';
				break;
			
			case 'casting':
				$url = 'http://www.allocine.fr/film/fichefilm-'.$query.'/casting/';
				break;

			case 'search':
				$url = "http://www.allocine.fr/recherche?q=".str_replace(' ','+',$query); 
				break;

			default:
				return null;
		}

		$ctx = stream_context_create(array( 
		    'http' => array( 
		        'timeout' => 60
		        ) 
		    ) 
		); 

		return file_get_html($url, false, $ctx);
	}


	public function searchResults($searchString){
		// Attention, des erreurs on été cachées par les @ devant la fonction.


		$html = $this->getHtml($searchString,'search');
		debug($html);
		$ret = $html->find('div.vmargin10t',0);
		$ret->onLoad =  "$('a:first').focus()"; // TODO ne fonctionne pas.
		foreach($ret->find('a') as $a){
		    $a->onclick = "videoLinkSelected('http://allocine.fr".$a->href."'); return false;";
		    $a->tabindex = "1";
		}
		return $ret;

	}


    public function parse($id) {
    $this->log("[AllocineParser::parse] Début.");
		$ret = array();

		// Infos de l'onglet d'accueil de la fiche du film
		$html = $this->getHtml($id,'general');

		$this->log("[AllocineParser::parse] Page d'infos générales récupérée.");

		$ret[$this->fieldNames['title']] = trim($html->find('div#title',0)->find('span',0)->innertext);
		$ret[$this->fieldNames['description']] = trim($html->find('p[itemprop=description]',0)->innertext);
		$ret[$this->fieldNames['poster']] = trim($html->find('div.poster',0)->find('img[itemprop=image]',0)->src);


		$html = $html->find('div.data_box',0);

		foreach( $html->find('li') as $k => $v){
			switch (trim($v->find('span',0)->innertext)) {
				case 'Genre':
					foreach ($v->find('a|span.acLnk') as $l => $w) {
						$ret[$this->fieldNames['genre']][] = trim($w->find('span',0)->innertext);
					}
					break;
				
				case 'Date de sortie':
					$relDate = @strtotime(trim($v->find('span[itemprop=datePublished]',0)->content));

					$ret[$this->fieldNames['datePublished'].'Year'] = date("Y", $relDate);
					$ret[$this->fieldNames['datePublished'].'Month'] = date("m", $relDate);
					$ret[$this->fieldNames['datePublished'].'Day'] = date("d", $relDate);

					$duration = trim(@$v->find('span[itemprop=duration]',0)->innertext);
					// on passe l'heure du format H'h 'MM'mins' en HH:MM
					$duration = strtotime('0'.str_replace('h ',':',str_replace('min','',$duration)));
					if($duration){
						$ret[$this->fieldNames['duration'].'Hour'] = date("H", $duration);
						$ret[$this->fieldNames['duration'].'Min'] = date("i", $duration);	
					}else{
						$ret[$this->fieldNames['duration'].'Hour'] = 0;
						$ret[$this->fieldNames['duration'].'Min'] = 0;	
					}
					
					break;

				case 'Nationalité':
					// Lien remplacé par un span quand on parse... wtf?
					$nationalityLink = $v->find('a|span.acLnk',0);
					$ret[$this->fieldNames['nationality']] = trim($nationalityLink->innertext);



					// Etape gourmande (Chargement d'une page supplémentaire) et pas indispensable.
					// TODO: enlever?
					//$countryPage = file_get_html('allocine.fr'.$nationalityLink->href);
					//$ret['nationality']['label'] = $nationalityLink->innertext;
					//$ret['nationality']['country'] = $countryPage->find('div.titlebar')->first_child->innertext;
					break;

				default:
					break;
			}
		}

		// TODO note x 4 pour être noté sur 20
		$ratingTag = $html->find('span.note',0);
		$ret[$this->fieldNames['rating']] =  4 * (float)trim(@$html->find('span.note',0)->innertext);

		$this->log("[AllocineParser::parse] Fin traitement infos générales");

		// Infos de la fiche casting
		$html = $this->getHtml($id,'casting');

		$this->log("[AllocineParser::parse] Page casting récupérée.");

		$director = $html->find('div.media_list_02',0)->find('li[itemscope]',0);
		$ret[$this->fieldNames['director']] = trim($director->find('span[itemprop]',0)->innertext);

		$actors = $html->find('div.media_list_02',1)->find('li[itemscope]');	
		foreach ($actors as $key => $value) {
			$ret[$this->fieldNames['actors']][] = trim($value->find('span[itemprop]',0)->innertext);
		}
		$this->log("[AllocineParser::parse] Fin.");
		return $ret;      
    }
}
?>