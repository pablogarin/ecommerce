<?php
class Banner{

    private $id;
    private $data;
    private $model;
    private $template = "banner.html";

    public function __construct($id)
    {
        if( !is_numeric($id) ){
            throw new Exception("La id ingresada para el Banner es invalida.");
            exit;
        }
        if( $id === null || empty($id) ){
            throw new Exception("Debe ingresar la id para el Banner.");
            exit;
        }
        /*
        if( is_numeric($id) || $id === null || empty($id) ){
            throw new Exception("La id ingresada para el Banner es invalida.");
            exit;
        }
        //*/
        $this->id = $id;
        $this->getData();
    }
    public function getID()
    {
        return $this->id;
    }
    public function getData()
    {
        global $dbh;
        $model = new \Modelos\Banner($dbh);
        $data = $model->query->byField(array("id"=>$this->id), null, null, false);
        if( $data === false ){
            throw new Exception("No se encontr&oacute; el banner en la base de datos.");
            exit;
        }
        $this->data = $data[0];
        return $this->data;
    }
    public function getView()
    {
        $view = new View();
        $view->setFolder(PATH."/templates");
        foreach( $this->data as $k=>$v ){
            $view->set($k, $v);
        }

        $view->setTemplate($this->template);
        return $view->getView();
    }
}
?>
