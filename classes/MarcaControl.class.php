<?php
class MarcaControl{
	function __construct($id){
		if( $id==null || empty($id) ){
			Throw new Exception("La clase 'MarcaControlador' necesita una id valida.");
			exit;
		}
		$this->setID($id);
		$this->getData();
	}
	private function setID($id){
		if( !is_numeric($id) ){
			Throw new Exception("La id debe ser un numero.");
			exit;
		}
		$this->id = $id;
	}
	public function getData(){
		global $dbh;
		$data = $dbh->query("SELECT * FROM marca WHERE id=?;",array($this->id));
        if( isset($data[0]) ){
            $data = $data[0];
            
            /* FOTO */
            $resource = $data['foto'];
            if( $tmp = $dbh->query("SELECT * FROM recurso WHERE id=?;",array($resource)) ){
                $resource = $tmp[0];
                $data['foto'] = $resource;
            }
            
            $this->data = $data;
            return $this->data;
        }
        return false;
	}
}
?>
