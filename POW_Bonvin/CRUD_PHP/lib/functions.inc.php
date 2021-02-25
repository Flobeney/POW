<?php
/*
  Date       : Octobre 2020
  Auteur     : P. Bonvin
  Sujet      : Librairie de fonctions php
 */
require "./lib/constantes.inc.php";

/**
 * Connecteur de la base de données du .
 * Le script meurt (die) si la connexion n'est pas possible.
 * @staticvar PDO $dbc
 * @return \PDO
 */
function dbnotes()
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

/**
 * Retourne les données d'une note en fonction de son idnote
 * @param mixed $idnote 
 * @return false|array 
 */
function readNote($idnote)
{
  static $ps = null;
  $sql = 'SELECT idnote, branche, DATE_FORMAT(date, \'%Y-%m-%d\') as date, round(note,2) as note,';
  $sql .= ' remarque, coefficient FROM dbnotes.notes';
  $sql .= ' WHERE idnote = :IDNOTE';

  if ($ps == null) {
    $ps = dbnotes()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':IDNOTE', $idnote, PDO::PARAM_INT);

    if ($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  return $answer;
}

/**
 * Lit les 50 premières notes par défaut.
 * @staticvar pdo prepare statement $ps
 * @param int $from A partir de la note $from (0 par défaut)
 * @param int Jusqu'à la note $offset (50 par défaut) 
 * @return false|array 
 */
function readNotes($from = 0, $offset = 50)
{
  static $ps = null;
  $sql = 'SELECT idnote, branche, DATE_FORMAT(date, \'%d/%m/%Y\') as date, round(note,2) as note,';
  $sql .= ' remarque, coefficient FROM dbnotes.notes';
  $sql .= ' ORDER BY branche, date ASC LIMIT :FROM,:OFFSET;';

  if ($ps == null) {
    $ps = dbnotes()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':FROM', $from, PDO::PARAM_INT);
    $ps->bindParam(':OFFSET', $offset, PDO::PARAM_INT);

    if ($ps->execute())
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  return $answer;
}

/**
 * Retourne les notes correspondant au filtre pour l'intervale $from, $from + $offset.
 * Par exemple $filter = "Anglais" ou $filter = "5.5".
 * @param mixed $filtre Filtre générique appliqué par LIKE. Voir dans la fonctions la requête correspondant.
 * @param int $from  A partir de la note filtrée $from (0 par défaut)
 * @param int $offset Jusqu'à la note $offset (50 par défaut) 
 * @return false|array 
 */
function readNotesWithFilter($filtre, $from = 0, $offset = 50)
{
  static $ps = null;
  $sql = 'SELECT idnote, branche, DATE_FORMAT(date, \'%d/%m/%Y\') as date,  round(note,2) as note, remarque, coefficient FROM dbnotes.notes';
  $sql .= " WHERE branche LIKE :FILTER OR date LIKE :FILTER OR note LIKE :FILTER";
  $sql .= " ORDER BY branche, date ASC LIMIT :FROM,:OFFSET;";

  // Prépare le LIKE
  $filtre = '%' . $filtre . '%';

  if ($ps == null) {
    $ps = dbnotes()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':FILTER', $filtre, PDO::PARAM_STR);
    $ps->bindParam(':FROM', $from, PDO::PARAM_INT);
    $ps->bindParam(':OFFSET', $offset, PDO::PARAM_INT);

    if ($ps->execute()) {
      $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  return $answer;
}

/**
 * Ajoute une nouvelle note avec ses paramètres
 * @param mixed $branche Nom de la branche
 * @param mixed $date  Date de la note
 * @param mixed $note  Valeur de la note
 * @param mixed $remarque Remarque concernant la note
 * @param mixed $coefficient Coefficient de la branche
 * @return bool true si réussi
 */
function createNote($branche, $date, $note, $remarque, $coefficient)
{
  static $ps = null;
  $sql = "INSERT INTO `dbnotes`.`notes` (`branche`, `date`, `note`, `remarque`, `coefficient`) ";
  $sql .= "VALUES (:BRANCHE, :DATE, round(:NOTE,2), :REMARQUE, :COEFFICIENT)";
  if ($ps == null) {
    $ps = dbnotes()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':BRANCHE', $branche, PDO::PARAM_STR);
    $ps->bindParam(':DATE', $date, PDO::PARAM_STR);
    $ps->bindParam(':NOTE', $note, PDO::PARAM_STR);
    $ps->bindParam(':REMARQUE', $remarque, PDO::PARAM_STR);
    $ps->bindParam(':COEFFICIENT', $coefficient, PDO::PARAM_INT);

    $answer = $ps->execute();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  return $answer;
}

/**
 * Met à jour une note existante 
 * @param mixed $idnote 
 * @param mixed $branche 
 * @param mixed $date 
 * @param mixed $note 
 * @param mixed $remarque 
 * @return bool 
 */
function updateNote($idnote, $branche, $date, $note, $remarque)
{
  static $ps = null;

  $sql = "UPDATE `dbnotes`.`notes` SET ";
  $sql .= "`branche` = :BRANCHE, ";
  $sql .= "`date` = :DATE, ";
  $sql .= "`note` = :NOTE, ";
  $sql .= "`remarque` = :REMARQUE ";
  $sql .= "WHERE (`idnote` = :IDNOTE)";
  if ($ps == null) {
    $ps = dbnotes()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':BRANCHE', $branche, PDO::PARAM_STR);
    $ps->bindParam(':DATE', $date, PDO::PARAM_STR);
    $ps->bindParam(':NOTE', $note, PDO::PARAM_STR);
    $ps->bindParam(':REMARQUE', $remarque, PDO::PARAM_STR);
    $ps->bindParam(':IDNOTE', $idnote, PDO::PARAM_INT);
    $ps->execute();
    $answer = ($ps->rowCount() > 0);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  return $answer;
}

/**
 * Supprime la note ave l'id $idnote.
 * @param mixed $idnote 
 * @return bool 
 */
function deleteNote($idnote)
{
  static $ps = null;
  $sql = "DELETE FROM `dbnotes`.`notes` WHERE (`idnote` = :IDNOTE);";
  if ($ps == null) {
    $ps = dbnotes()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':IDNOTE', $idnote, PDO::PARAM_INT);
    $ps->execute();
    $answer = ($ps->rowCount() > 0);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  return $answer;
}

/**
 * Retourne les branches disponibles.
 * @staticvar array $branches
 * @return array
 */
function branches()
{
  // Les branches devraient se trouver dans une table et la base devrait être normalisée.
  // Pour ne pas complexifier cet exemple, les branches sont dans un tableau PHP.
  // La clé est le nom de la branche, le valeur est son coefficient
  //  static $branches = array(
  //    "Langue & Société" => 1,
  //    "Société" => 1,
  //    "Anglais" => 1,
  //    "Mathématiques" => 2,
  //    "Physique" => 2,
  //    "Education Physique" => 1
  //  );
  // return $branches;
  return array(
    "Langue & Société" => 1,
    "Société" => 1,
    "Anglais" => 1,
    "Mathématiques" => 2,
    "Physique" => 2,
    "Education Physique" => 1
  );
}

/**
 * Converti le tableau des branches en select / option html
 * @param mixed $brancheSelected La branche "Selected"
 * @return string Un select html
 */
function brancheToSelect($brancheSelected)
{

  $html = "\n\t<select name=\"branche\">";

  foreach (branches() as $branche => $coefficient) {
    $selected = ($brancheSelected == $branche ? "selected" : "");
    $html .= sprintf("\n\t\t<option value=\"%s\" %s>%s</option>", $branche, $selected, $branche);
  }
  $html .= "\n\t</select>";
  return $html;
}

/**
 * Retourne le coefficient en fonction du nom de la branche
 * @param string $branche
 * @return int
 */
function coefficient($branche)
{
  return (isset(branches()[$branche]) ? branches()[$branche] : 0);
}

/**
 * Convertir un tableau PHP en table html.
 * Usage : echo arrayToHtmlTable($array);
 * @param associative array $array
 * @param bool $header affiche la première ligne en th avec le nom des colonnes
 * @return string le tableau html sous forme de string.
 */
function arrayToHtmlTable($array, $header = true)
{
  $html = "";
  if (!empty($array)) {

    $html .= "\n  <table>";
    // Entete ?
    if ($header) {
      $html .= "\n    <tr>";
      foreach ($array[0] as $key => $value) {
        $html .= "\n      <th>$key</th>";
      }
      $html .= "\n    </tr>\n";
    }
    // Chaque ligne
    foreach ($array as $line) {
      $html .= "\n    <tr>";
      // Contient un  tableau
      foreach ($line as $value) {
        $html .= "\n      <td>$value</td>\n";
      }
      $html .= "\n    </tr>\n";
    }
    $html .= "\n  </table>\n";
  }
  return $html;
}

/**
 * Converti le tableau de notes PHP en tableau HTML
 * @param mixed $array 
 * @return string 
 */
function notesToHtmlTable($array)
{
  $html = "";
  if (!empty($array)) {

    $html .= "\n  <table>";

    // Affichage de l'entete
    $html .= "\n    <tr>";
    foreach ($array[0] as $key => $value) {
      $html .= "\n      <th>$key</th>";
    }
    $html .= "\n    </tr>\n";

    // Chaque ligne
    foreach ($array as $line) {
      $html .= "\n    <tr>";
      // Contient un  tableau
      foreach ($line as $key => $value) {
        if ($key == "editer") {
          $html .= "\n      <td><a href=\"?editer=$value\">editer</a></td>\n";
        } else if ($key == "supprimer") {
          $html .= "\n      <td><a href=\"?supprimer=$value\">supprimer</a></td>\n";
        } else {
          $html .= "\n      <td>$value</td>\n";
        }
      }
      $html .= "\n    </tr>\n";
    }
    $html .= "\n  </table>\n";
  }
  return $html;
}