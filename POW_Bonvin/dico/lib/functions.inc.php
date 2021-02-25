<?php
require "./lib/constantes.inc.php";

/**
 * Connecteur de la base de données du .
 * Le script meurt (die) si la connexion n'est pas possible.
 * @staticvar PDO $dbc
 * @return \PDO
 */
function connecteur()
{
    static $dbc = null;

    // Première visite de la fonction
    if ($dbc == null) {
        // Essaie le code ci-dessous
        try {
            $dbc = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, DBUSER, DBPWD, array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_PERSISTENT => true
            ));
        }
        // Si une exception est arrivée
        catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage() . '<br />';
            echo 'N° : ' . $e->getCode();
            // Quitte le script et meurt
            die('Could not connect to MySQL');
        }
    }
    // Pas d'erreur, retourne un connecteur
    return $dbc;
}

//SELECT

function readDico($from = 0, $offset = 50){
    static $ps = null;
    
    $sql = "SELECT idfrancais, mot, definition 
    FROM francais
    ORDER BY mot LIMIT :FROM,:OFFSET;";

    if ($ps == null) {
        $ps = connecteur()->prepare($sql);
    }
    $answer = false;
    try {
        $ps->bindParam(':FROM', $from, PDO::PARAM_INT);
        $ps->bindParam(':OFFSET', $offset, PDO::PARAM_INT);

        if ($ps->execute()){
            $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    return $answer;
}

function readDicoFilter($filter, $from = 0, $offset = 50){
    static $ps = null;
    
    $sql = "SELECT idfrancais, mot, definition 
    FROM francais
    WHERE mot LIKE :FILTER
    OR definition LIKE :FILTER
    ORDER BY mot LIMIT :FROM,:OFFSET;";

    //Préparer le filtre
    $filter = '%' . $filter . '%';

    if ($ps == null) {
        $ps = connecteur()->prepare($sql);
    }
    $answer = false;
    try {
        $ps->bindParam(':FILTER', $filter, PDO::PARAM_STR);
        $ps->bindParam(':FROM', $from, PDO::PARAM_INT);
        $ps->bindParam(':OFFSET', $offset, PDO::PARAM_INT);

        if ($ps->execute()){
            $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    return $answer;
}