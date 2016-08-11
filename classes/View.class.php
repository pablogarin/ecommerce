<?php
class View{
    private $dataBag;
    public function __construct(){
        $this->dataBag = array();
    }
    public function setFolder($folder){
        $this->folder = $folder;
    }
    public function setTemplate($template){
        $this->template = $template;
    }
    public function set($key,$value){
        $this->dataBag[$key] = $value;
    }
    public function getView(){
        include_once 'Twig/Autoloader.php';
        Twig_Autoloader::register();
        try {
        // specify where to look for templates
        $loader = new Twig_Loader_Filesystem($this->folder);

        // initialize Twig environment
        $twig = new Twig_Environment($loader);
        $path = ini_get('include_path').PATH_SEPARATOR.PATH."/html/libs/Twig/Extensions/Extension/";
        ini_set("include_path", $path);
        include_once("Intl.php");
        $twig->addExtension(new Twig_Extensions_Extension_Intl());

        // load template
        $template = $twig->loadTemplate($this->template);

        // set template variables
        // render template
        return $template->render($this->dataBag);

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        } 
    }
}
?>
