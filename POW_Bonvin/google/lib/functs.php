<?php
require 'consts.php';
require 'vendor/autoload.php';
use League\HTMLToMarkdown\HtmlConverter;

class MyDico
{
    //Champs
    //Connexion à la BDD avec le PDO
    private $dbh = null;
    //Prepare Statement
    private $ps_match_bool = null;
    private $ps_match_natural = null;
    private $ps_match_exp = null;
    private $ps_insert = null;
    //Converter
    private $converter = null;

    //Moyen de recherche
    public $search_term = "";
    //Mode de recherche
    public $search_mode = "";

    //Constructeur
    public function __construct(){

        if ($this->dbh == null) {
            try {
                //Connexion à la BDD avec le PDO
                $this->dbh = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, DBUSER, DBPWD, array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_PERSISTENT => true
                ));

                //SQL de recherche MATCH AGAINST (boolean mode)
                $sql_match_bool = "SELECT url, content_md FROM ressources WHERE MATCH (content_md) AGAINST (:search_term IN BOOLEAN MODE);";
                $this->ps_match_bool = $this->dbh->prepare($sql_match_bool);
                $this->ps_match_bool->setFetchMode(PDO::FETCH_ASSOC);

                //SQL de recherche MATCH AGAINST (natural mode)
                $sql_match_natural = "SELECT url, content_md, 
                MATCH(content_md) AGAINST(:search_term IN NATURAL LANGUAGE MODE) as score 
                FROM ressources ORDER BY score DESC;";
                $this->ps_match_natural = $this->dbh->prepare($sql_match_natural);
                $this->ps_match_natural->setFetchMode(PDO::FETCH_ASSOC);

                //SQL de recherche MATCH AGAINST (expansion mode)
                $sql_match_exp = "SELECT url, content_md FROM ressources WHERE MATCH (content_md) AGAINST (:search_term WITH QUERY EXPANSION);";
                $this->ps_match_exp = $this->dbh->prepare($sql_match_exp);
                $this->ps_match_exp->setFetchMode(PDO::FETCH_ASSOC);

                //SQL pour l'insertion
                $sql_insert = 'INSERT INTO ressources (url, content_md, content_html) VALUES (:url, :content_md, :content_html)';
                $this->ps_insert = $this->dbh->prepare($sql_insert);

                //Converter
                $this->converter = new HtmlConverter([
                    'strip_tags' => true,
                    'remove_nodes' => 'script footer noscript head nav',
                    'hard_break' => true,
                    'use_autolinks' => true,
                    'header_style' => 'atx',
                ]);
            } catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br>";
                die();
            }
        }
    }

    //Recherche
    function search(){
        $res = null;
        // Tente la recherche sur le dictionnaire
        try {
            switch ($this->search_mode) {
                case 'Natural mode':
                    echo 'Natural';
                    $this->ps_match_natural->execute(array(':search_term' => $this->search_term));
                    $res = $this->ps_match_natural->fetchAll();
                    break;
                    
                case 'Expansion mode':
                    echo 'Expansion';
                    $this->ps_match_exp->execute(array(':search_term' => $this->search_term));
                    $res = $this->ps_match_exp->fetchAll();
                    break;
                
                //Boolean
                default:
                    echo 'Boolean';
                    $this->ps_match_bool->execute(array(':search_term' => $this->search_term));
                    $res = $this->ps_match_bool->fetchAll();
                    break;
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $res;
    }

    //Ajouter une ressource
    function addRessource($url){
        $html = file_get_contents($url);
        $markdown = $this->converter->convert($html);
        $html = htmlspecialchars($html);

        //Insert
        if (!$this->ps_insert->execute(array(
            ':url' => $url,
            ':content_md' => $markdown,
            ':content_html' => $html
        ))) {
            echo "Echec lors de l'exécution ";
            var_dump($this->ps_insert->errorInfo());
        }
    }
}
