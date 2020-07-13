<?php

class CitiesController extends \Phalcon\Mvc\Controller
{
	
    public function indexAction()
    {
		
    }
	
    public function nothingFoundAction()
    {
		
    }
	
    public function toMuchFoundAction()
    {

    }
	
    public function unknownAction()
    {

    }


    public function findAction()
    {
		if( $this->request->isPost() ) {
			$city = $this->request->getPost('city', 'string');
			$re = '/^((\+|-)?(?:90(?:(?:\.0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,6})?)))(?:\W+)((\+|-)?(?:180(?:(?:\.0{1,6})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,6})?)))$/';
			
			if( !preg_match($re, $city, $matches) ) {
				//введено название города
				$address = json_decode(file_get_contents("http://search.maps.sputnik.ru/search?q=".urlencode($city)));
				
				if( $address->meta->found == 1 ) {
					//корректно
					
				}elseif( $address->meta->found == 0 && !empty($address->typo->FixedQuery) ) {
					//очепятка
					$address = json_decode(file_get_contents("http://search.maps.sputnik.ru/search?q=".urlencode($address->typo->FixedQuery)));
					
				}elseif( $address->meta->found == 0 && empty($address->typo->FixedQuery) ) {
					//ничего
					return $this->dispatcher->forward(
						array(
						"action" => "nothingFound"
						)
					);
					
				}elseif( $address->meta->found > 1 ) {
					//перебор
					return $this->dispatcher->forward(
						array(
						"action" => "toMuchFound"
						)
					);
					
				}else{
					//неизведанное
					return $this->dispatcher->forward(
						array(
						"action" => "unknown"
						)
					);
				}
				
				if( empty($address->result[0]) ) {
					//очепятка исправлена, а результата всё равно нету
					return $this->dispatcher->forward(
						array(
						"action" => "nothingFound"
						)
					);
				}
				
				$city = $address->result[0]->title;
				$lat  = $address->result[0]->position->lat;
				$lon  = $address->result[0]->position->lon;
				
				if( empty(Cities::findFirst("city = '" . $city . "'")) ) {
					$option = new Cities();
					$option->city = $city;
					$option->lat = $lat;
					$option->lon = $lon;
					$option->save();
					// Redis
					$this->redis->set($option->id,$city);
				}
			
			} else {
				//введены кординаты
				$lat = urlencode($matches[1]);
				$lon = urlencode($matches[3]);
			}
			$result = json_decode(file_get_contents("https://api.openweathermap.org/data/2.5/onecall?lat={$lat}&lon={$lon}&appid=7d353f8711cb172f06ec81998928b850"));
			return $this->dispatcher->forward(
				array(
				"action" => "show",
				"params" => [$result]
				)
			);
		}
    }
	
	public function listAction()
    {
		$this->view->cities = Cities::find();
    }

	
	public function showAction($result)
	{
		$this->view->result = $result;
	}
}

