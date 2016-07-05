<?php
class Buscador{
	private $search, $options, $results;
	function __construct($search,$options=null){
		if( gettype($search)!=='string' ){
			Throw new Exception("La clase busqueda recibe como parametro una cadena de texto, se le paso un objeto de tipo '" . gettype($search) . "'");
			exit;
		}
		$this->search = $search;
		if( $options!=null && is_array($options) ){
			$this->options = $options;
		}
		$this->performSearch();
	}
	private function performSearch(){
		global $Sql;
		$query = "SELECT * FROM producto WHERE (";
		$singleLine = "nombre like ? or SKU like ? or descripcion like ? or tags like ?";
		$orderLine = "CASE WHEN nombre like '%{NOMBRE}%' or SKU like '%{LIKE}%' or descripcion like '%{LIKE}%' or tags like '%{LIKE}%' THEN 1 ELSE 2 END";
		$words = $this->search;
		$words = explode(' ', $words);
		$data = array();
		$conditions = array();
		$order = array();
		foreach( $words as $word ){
			$word = preg_replace('/[^a-zA-Z1-9]/','_',$word); //reemplazamos todos los caracteres raros por comodin. De pasada le da una capa extra de seguridad.
			$word = str_replace('__','_',$word); // cuando la codificacion no es utf-8, las vocales con acento devuelven 2 caracteres desconocidos.
			$nombre = preg_replace('/[aeiouAEIOU]/','_',$word);
			$data[] = "%$nombre%";
			$data[] = "%$word%";
			$data[] = "%$word%";
			$data[] = "%$word%";
			$conditions[] = $singleLine;
			$tmp = $orderLine;
			$tmp = str_replace('{NOMBRE}',$nombre,$tmp);
			$tmp = str_replace('{LIKE}',$word,$tmp);
			$order[] = $tmp;
		}
		$query.=join(" OR ",$conditions);
		$query.= ") and activo=1 ORDER BY ".join(", ",$order).";";
		$cur = $Sql->q_read($query,$data);
		// print_r($Sql);
		// exit($query);
		if( $cur!==false && isset($cur[0]) && is_array($cur[0]) ){
			$this->results = $cur;
		} else {
			$this->results = array();
		}
	}
	public function getResults(){
		return $this->results;
	}
}
?>
