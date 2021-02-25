<?php

// Les réglages de la base
define("HOST", "localhost");
define("DBNAME", "dictionnaire");
define("DBUSER", "flore");
define("DBPWD", "Super2012");

class MyDico
{

    private
        $psexact = null;
    private
        $psmatch = null;
    private
        $psreplace = null;
    private
        $dbh = null;
    public
        $search_term = "";
    public
        $search_type = "";

    public function __construct()
    {

        if ($this->dbh == null) {
            try {
                $this->dbh = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, DBUSER, DBPWD, array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_PERSISTENT => true
                ));

                // Trois prepare statements
                $sqlexact = "SELECT mot,definition FROM francais WHERE mot = :search_term ORDER BY mot ASC";
                $this->psexact = $this->dbh->prepare($sqlexact);
                $this->psexact->setFetchMode(PDO::FETCH_ASSOC);

                $sqlmatch = "SELECT mot,definition FROM francais WHERE MATCH (mot,definition) AGAINST (:search_term) ORDER BY mot ASC";
                $this->psmatch = $this->dbh->prepare($sqlmatch);
                $this->psmatch->setFetchMode(PDO::FETCH_ASSOC);

                $sqlreplace = 'SELECT mot,REPLACE(definition, "\n", " ") as def FROM francais WHERE mot = :word';
                $this->psreplace = $this->dbh->prepare($sqlreplace);
                $this->psreplace->setFetchMode(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br>";
                die();
            }
        }
    }

    // S'assure que le text est un  ascii 7 bits
    private function removeAccent($text)
    {
        return @iconv('UTF-8', 'US-ASCII//TRANSLIT', $text);
    }

    /**
     * Cherche si le $word est dans le dictionnaire.
     * Si oui, transforme le mot en lien html
     * Si non, retourne le mot
     * @param String $word Le mot a rechercher
     * @return string
     */
    private function wordToLink($word)
    {

        $word = $word[0];
        $word_search = strtolower($this->removeAccent($word));
        //$word_search = $word;
        $this->psreplace->execute(array(':word' => $word_search));

        if ($this->psreplace->rowcount() > 0) {
            $req = $this->psreplace->fetch();
            $str = "";
            $str .= '<a title="';
            $str .= $req["def"];
            $str .= '" href="?word=';
            $str .= $word;
            $str .= '"';
            if ($word_search == strtolower($this->search_term))
                $str .= ' class="fluo"';
            $str .= '>';
            $str .= $word;
            $str .= "</a>";
            return $str;
        } else {
            return $word;
        }
    }

    /**
     * Fonction qui décompose les mots d'une définition et vérifie pour chacun s'il est
     * dans le dictionnaire à l'aide de la fonction wordToLink.
     * @param string $definition
     * @return string
     */
    function definitionToTextWithLink($definition)
    {
        return preg_replace_callback('/[\wéèêëáàâäóòôöíìîïúùûü]{2,}/', 'MyDico::wordToLink', $definition);
    }

    function getDefinitions()
    {
        // Tente la recherche sur le dictionnaire
        try {
            switch ($this->search_type) {
                case "full":
                    $this->psmatch->execute(array(':search_term' => $this->search_term));
                    $definitions = $this->psmatch->fetchAll();
                    break;
                default: // same as "Exactword"
                    $this->psexact->execute(array(':search_term' => $this->search_term));
                    $definitions = $this->psexact->fetchAll();
                    break;
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $definitions;
    }
}
