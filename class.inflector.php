<?php

class Inflector {

	/* 
	 * Inflector Class
	 * 
	 * These methods are somewhat ported from Rails, via:
	 * http://www.akelos.com/docs/inflector.htm
	 * 
	 * However, they've been modified to add the additional methods
	 * and bring all the routines into a consistent space and PHP
	 * classes.
	 */

	static $plural = array(
		'/(quiz)$/i'								=> '\\1zes',
		'/^(ox)$/i'									=> '\\1en',
		'/([m|l])ouse$/i'						=> '\\1ice',
		'/(matr|vert|ind)ix|ex$/i'	=> '\\1ices',
		'/(x|ch|ss|sh)$/i'					=> '\\1es',
		'/([^aeiouy]|qu)y$/i'				=> '\\1ies',
		'/([^aeiouy]|qu)ies$/i'			=> '\\1y',
		'/(hive)$/i'								=> '\\1s',
		'/(?:([^f])fe|([lr])f)$/i'	=> '\\1\\2ves',
		'/sis$/i'										=> 'ses',
		'/([ti])um$/i'							=> '\\1a',
		'/(buffal|tomat)o$/i'				=> '\\1oes',
		'/(bu)s$/i'									=> '\\1ses',
		'/(alias|status)$/i'				=> '\\1es',
		'/(octop|vir)us$/i'					=> '\\1i',
		'/(ax|test)is$/i'						=> '\\1es'
		);

	static $singular = array(
		'/(quiz)zes$/i'							=> '\\1',
		'/(matr)ices$/i'						=> '\\1ix',
		'/(vert|ind)ices$/i'				=> '\\1ex',
		'/^(ox)en/i'								=> '\\1',
		'/(alias|status)es$/i'			=> '\\1',
		'/([octop|vir])i$/i'				=> '\\1us',
		'/(cris|ax|test)es$/i'			=> '\\1is',
		'/(shoe)s$/i'								=> '\\1',
		'/(o)es$/i'									=> '\\1',
		'/(bus)es$/i'								=> '\\1',
		'/([m|l])ice$/i'						=> '\\1ouse',
		'/(x|ch|ss|sh)es$/i'				=> '\\1',
		'/(m)ovies$/i'							=> '\\1ovie',
		'/(s)eries$/i'							=> '\\1eries',
		'/([^aeiouy]|qu)ies$/i'			=> '\\1y',
		'/([lr])ves$/i'							=> '\\1f',
		'/(tive)s$/i'								=> '\\1',
		'/(hive)s$/i'								=> '\\1',
		'/([^f])ves$/i'							=> '\\1fe',
		'/(^analy)ses$/i'						=> '\\1sis',
		'/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i' => '\\1\\2sis',
		'/([ti])a$/i'								=> '\\1um',
		'/(n)ews$/i'								=> '\\1ews',
		'/s$/i'											=> '',
		);

	static $uncountable = array(
		'alumni',
		'athletics',
		'equipment',
		'information',
		'rice',
		'money',
		'species',
		'series',
		'fish',
		'los angeles',
		'people',
		'physics',
		'politics',
		'sheep',
		'open to the public',
		'community engagement',
		'teacher education'
		);

	static $irregular = array(
		//'alumnus' => 'alumni',
		'campus' => 'campuses',
		'person' => 'people',
		'man' => 'men',
		'child' => 'children',
		'sex' => 'sexes',
		'move' => 'moves'
		);

	public function pluralize_if ( $string, $object ) {

		// pluralize the string if the count of the object is greater than one
		if ( is_array($object) && count($object) > 1 ) return Inflector::pluralize($string);

		return $string;

	}

	private function ends_with ( $pattern, $string ) {

		// checks the string to see if it ends with a pattern
		return (bool) (preg_match('/(' . preg_quote($pattern) . ')$/i', $string));

	}

	private function replace_ending ( $pattern, $replacement, $string ) {

		// checks the string to see if it ends with a pattern
		return (string) (preg_replace('/^(.*)' . preg_quote($pattern) . '$/i', '\\1' . $replacement, $string));
		//return (string) (preg_replace('/^.+(' . preg_quote(substr($pattern, 1)) . ')$/i', '\\1' . substr($replacement, 1), $string));

	}

	public function add () {
		$args = func_get_args();
		if ( count($args) < 2 ) return FALSE;
		switch ( array_shift($args) ) {
			case 'uncountable':
				if ( !isset($this->uncountable_additions) ) $this->uncountable_additions = array();
				while ( count($args) ) {
					$arg = array_shift($args);
					if ( is_string($arg) ) $this->uncountable_additions[] = $arg;
					else if ( is_array($arg) ) $this->uncountable_additions = array_merge($this->uncountable_additions, array_values($arg));
				}
				break;
			case 'irregular':
				if ( !isset($this->irregular_additions) ) $this->irregular_additions = array();
				while ( count($args) ) {
					$arg = array_shift($args);
					if ( is_array($arg) && !is_numeric(key($arg)) ) $this->irregular_additions = array_merge($this->irregular_additions, $arg); 				}
				break;
		}
		return TRUE;
	}

	private function uncountables () {

		if ( isset($this) && isset($this->uncountable_additions) ) return array_merge(Inflector::$uncountable, $this->uncountable_additions);
		return Inflector::$uncountable;

	}

	private function irregulars () {

		if ( isset($this) && isset($this->irregular_additions) ) return array_merge(Inflector::$irregular, $this->irregular_additions);
		return Inflector::$irregular;

	}

	private function is_uncountable ( $string ) {

		// test for ending in uncountable terms
		foreach ( Inflector::uncountables() as $_uncountable ) if ( Inflector::ends_with($_uncountable, $string) ) return TRUE;

		return FALSE;
		
	}

	public function is_plural ( $string ) {

		// is uncountable
		if ( Inflector::is_uncountable($string) ) return TRUE;

		// is already an irregular plural
		foreach ( Inflector::irregulars() as $_singular => $_plural ) if ( Inflector::ends_with($_plural, $string) ) return TRUE;

		// has a match to singularize
		foreach ( Inflector::$singular as $pattern => $replacement ) if ( preg_match($pattern, $string) ) return TRUE;

		return FALSE;

	}

	public function is_singular ( $string ) {

		// is uncountable
		if ( Inflector::is_uncountable($string) ) return TRUE;

		// is already an irregular singular
		foreach ( Inflector::irregulars() as $_singular => $_plural ) if ( Inflector::ends_with($_singular, $string) ) return TRUE;

		// has a match to pluralize
		foreach ( Inflector::$plural as $pattern => $replacement ) if ( preg_match($pattern, $string) ) return TRUE;

		return FALSE;

	}

	public function pluralize ( $string ) {

		// check to make sure this isn't already plural
		if ( Inflector::is_plural($string) ) return $string;

		// check for irregular singular forms
		foreach ( Inflector::irregulars() as $_singular => $_plural ) if ( Inflector::ends_with($_singular, $string) ) return Inflector::replace_ending($_singular, $_plural, $string);
	
		// check for matches using regular expression patterns
		foreach ( Inflector::$plural as $pattern => $replacement ) if ( preg_match($pattern, $string) ) return preg_replace($pattern, $replacement, $string);
	
		return preg_replace('/s$/i', '', $string) . 's';

	}

	public function singularize ( $string ) {

		// check to make sure this isn't already singular
		if ( Inflector::is_singular($string) ) return $string;

		// check for irregular plural forms
		foreach ( Inflector::irregulars() as $_singular => $_plural ) if ( Inflector::ends_with($_plural, $string) ) return Inflector::replace_ending($_plural, $_singular, $string);

		// check for matches using regular expression patterns
		foreach ( Inflector::$singular as $pattern => $replacement ) if ( preg_match($pattern, $string) ) return preg_replace($pattern, $replacement, $string);

		return $string;

	}

	public function to_sentence ( $array=array(), $separator=', ', $last_separator=' and ' ) {

		// takes an array of strings and assembles them into a sentence
		if ( empty($array) || !is_array($array) ) return '';
		if ( count($array) == 1 ) return current($array);
		$last = array_pop($array);

		return implode($separator, $array) . $last_separator . $last;

	}

	public function cardinalize ( $number ) {

		// takes the input and attempts to make it into a cardinal number
		$number = (int) $number;
		if ( !is_int($number) ) return '';
		$negative = '';
		if ( $number < 0 ) $negative = 'minus ';
		switch ( abs($number) ) {
			case  0: return "{$negative}zero";
			case  1: return "{$negative}one";
			case  2: return "{$negative}two";
			case  3: return "{$negative}three";
			case  4: return "{$negative}four";
			case  5: return "{$negative}five";
			case  6: return "{$negative}six";
			case  7: return "{$negative}seven";
			case  8: return "{$negative}eight";
			case  9: return "{$negative}nine";
			case 10: return "{$negative}ten";
			default: return (string) $number;
		}
	}

	public function ordinalize ( $number ) {

		// takes the input and attempts to make it into a ordinal number
		$number = (int) $number;
		if ( !is_int($number) ) return '';
		switch ( abs($number) ) {
			case  1: return "first";
			case  2: return "second";
			case  3: return "third";
			case  4: return "fourth";
			case  5: return "fifth";
			case  6: return "sixth";
			case  7: return "seventh";
			case  8: return "eighth";
			case  9: return "ninth";
			case 10: return "tenth";
			default: return (string) $number;
		}
	}

}

?>