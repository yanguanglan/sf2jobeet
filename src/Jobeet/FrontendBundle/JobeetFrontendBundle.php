<?php

namespace Jobeet\FrontendBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class JobeetFrontendBundle extends Bundle
{
	public static function slugify($text)
	{
		//Az ékezeteket eltávolítjuk. Fontos, hogy ezt végezzük el először
		$replace = array(
			'á' => 'a',
			'é' => 'e',
			'í' => 'i',
			'ó' => 'o',
			'ö' => 'o',
			'ő' => 'o',
			'ú' => 'u',
			'ü' => 'u',
			'ű' => 'u'
		);
		foreach($replace as $k => $v)
		{
			$text = str_replace($k,$v,$text);
		}
		
		//A nem szóépítő karaktereket lecseréljük egy kötőjelre (-)
		$text = preg_replace('/\W+/','-',$text);
		
		//Kisbetű, whitespace, és - eltávolítása $text elejéről és végéről
		$text = strtolower(trim($text,'-'));
		
		//Ha valami miatt üres lenne, akkor ne legyen az
		if (empty($text)) return 'n-a';
		
		return $text;
	}
}
