<?php

App::import('Vendor','TMDb');
include(APP . "Config" . DS . "APIKeys.php");
// App::uses('Component', 'Controller');

class TMDBComponent extends Component {
	public $components = array("Session");
	public $tmdb = null; // API

	private function init() {
		// @TODO
		// On regarde si une session TMDB a été ouverte
		// On récupère la config
		// On charge l'API
		$keys = get_class_vars('API_KEYS');
		$this->tmdb = new TMDb($keys['tmdb'],'fr');
		// Nécéssaire tant qu'on s'authentifie par bidouillage
		$this->tmdb->setAuthSession($keys['tmdbSession']);
	}

	public function searchMovie($query){
		$this->init();
		return $this->tmdb->searchMovie($query);
	}

	public function getMovie($id){
		$this->init();
		$movieInfo = $this->tmdb->getMovie($id);
		// debug($movieInfo);
		$movieCast = $this->tmdb->getMovieCast($id);
		// debug($movieCast);
		$movieReleases = $this->tmdb->getMovieReleases($id);
		// debug($movieReleases);

		$retour = array();
		// Nom Film
		$retour['VideoName'] = $movieInfo['title'];

		// Catégories
		foreach ($movieInfo['genres'] as $key => $value) {
			$retour['VideoCategories'][] = $value['name'];	
		}
		$retour['VideoCategories'] = implode(',',$retour['VideoCategories']);

		// Nationality
		if($movieInfo['production_countries']) $retour['CountryNationality'] = $movieInfo['production_countries'][0]['name'];

		// Date de sortie
		foreach ($movieReleases['countries'] as $key => $value) {
			if($value['iso_3166_1'] == 'FR'){
				$releaseDateArray = explode('-', $value['release_date']);		
				$retour['VideoReleasedateDay'] =  $releaseDateArray[2];
				$retour['VideoReleasedateMonth'] =  $releaseDateArray[1];
				$retour['VideoReleasedateYear'] =  $releaseDateArray[0];
				break;
			}
		}

		// Durée
		$retour['VideoDurationHour'] = (int)($movieInfo['runtime']/60);
		if($retour['VideoDurationHour'] < 10) $retour['VideoDurationHour'] = '0'.$retour['VideoDurationHour'];
		$retour['VideoDurationMin'] = $movieInfo['runtime']%60;
		if($retour['VideoDurationMin'] < 10) $retour['VideoDurationMin'] = '0'.$retour['VideoDurationMin'];

		// Note (note sur 10 => sur 20)
		$retour['VideoRating'] = (int)($movieInfo['vote_average'] * 2);

		// Synopsis
		$retour['VideoSynopsis'] = $movieInfo['overview'];

		// Jaquette
		$retour['VideoCover'] = 'http://cf2.imgobject.com/t/p/w185'.$movieInfo['poster_path'];

		// Acteurs
		foreach ($movieCast['cast'] as $key => $value) {
			$retour['VideoActeurs'][] = $value['name'];
		}
		$retour['VideoActeurs'] = implode(',',$retour['VideoActeurs']);

		// Réalisateur
		foreach ($movieCast['crew'] as $key => $value) {
			if($value['job'] == 'Director'){
				$retour['DirectorName'] = $value['name'];
				break;
			} 
		}

		return $retour;
	}

}


?>