<?php
require 'consts.php';

class MyDico
{
    //Champs
    //Connexion à la BDD avec le PDO
    private $dbh = null;
    //Prepare Statement
    private $ps_match_bool = null;
    private $ps_match_natural = null;

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
                $sql_match_bool = "SELECT id, content FROM ressources 
				WHERE MATCH (content) AGAINST (:search_term IN BOOLEAN MODE)
				ORDER BY id;";
                $this->ps_match_bool = $this->dbh->prepare($sql_match_bool);
                $this->ps_match_bool->setFetchMode(PDO::FETCH_ASSOC);

                //SQL de recherche MATCH AGAINST (natural mode)
                $sql_match_natural = "SELECT id, content, 
                MATCH(content) AGAINST(:search_term IN NATURAL LANGUAGE MODE) as score 
                FROM ressources 
				ORDER BY score DESC;";
                $this->ps_match_natural = $this->dbh->prepare($sql_match_natural);
                $this->ps_match_natural->setFetchMode(PDO::FETCH_ASSOC);

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
                    $this->ps_match_natural->execute(array(':search_term' => $this->search_term));
                    $tmp = $this->ps_match_natural->fetchAll();
					//Isoler les résultats avec un score > 0
					foreach ($tmp as $sentence) {
						if(floatval($sentence['score']) > 0){
							//Mettre le mot cherché en évidence
							$res[] = $this->highlightWord($this->search_term, $sentence);
						}
					}
                    break;
                
                //Boolean
                default:
                    $this->ps_match_bool->execute(array(':search_term' => $this->search_term));
                    $tmp = $this->ps_match_bool->fetchAll();

					foreach ($tmp as $sentence) {
						//Mettre le mot cherché en évidence
						$res[] = $this->highlightWord($this->search_term, $sentence);
					}
                    break;
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $res;
    }

	//Mettre en évidence un mot dans un phrase
	function highlightWord($word, $sentence){
		//Position du mot dans la phrase
		$pos = stripos($sentence['content'], $word);
		//Le mettre en gras
		$sentence['content'] = substr($sentence['content'], 0, $pos) . '<b>' . $word . '</b>' . substr($sentence['content'], $pos + strlen($word));

		return $sentence;
	}

}
