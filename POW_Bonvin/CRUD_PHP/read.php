<!DOCTYPE html>
<?php
/*
 * 2020 - PHP - Normes école informatique - CRUD - Prepare statements
 * Réaliser un CRUD sur une table simple MySql.
 * Auteur : P. Bonvin - Ecole d'informatique
 * Page read.php, affiche le contenu de la table avec critère de recherche
 */
require './lib/functions.inc.php';

//    Recherche
// --------------------------------------
//    Filtrer les notes du tableau.
$recherche = filter_input(INPUT_POST, "recherche");
?>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Normes crud_php</title>
    <link rel="stylesheet" type="text/css" href="./lib/crud.css">
</head>

<body>
    <h1>READ</h1>
    <nav>
        <?php include "./lib/nav.inc.php"; ?>
    </nav>
    <form action="#" method="POST">
        <table>
            <tr>
                <td>Choisissez un critère de recherche (branche, date) : </td>
                <td><input type="text" name="recherche" value="<?= $recherche ?>"></td>
                <td><input type="submit" name="btnSubmit" value="Rechercher"></td>
            </tr>
        </table>
    </form>
    <?php
  // Choix du tableau à afficher
  if (!empty($recherche))
    echo arrayToHtmlTable(readNotesWithFilter($recherche));
  else
    echo notesToHtmlTable(readNotes());
  ?>
    <footer>2020 - PHP - Normes école informatique - CRUD - Prepare statements</footer>
</body>

</html>