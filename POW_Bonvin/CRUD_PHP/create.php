<!DOCTYPE html>
<?php
/*
 * 2020 - PHP - Normes école informatique - CRUD - Prepare statements
 * Réaliser un CRUD sur une table simple MySql.
 * Auteur : P. Bonvin - Ecole d'informatique
 */
require './lib/functions.inc.php';

// initialisation des variables du script (évite les erreurs notice)
$branche = "Anglais";
$date = date("Y-m-d");
$remarque = "";
$note = 1.0;
$errorMsg = "Veuillez saisir les données du formulaire et cliquez sur Ajouter";

// Traitement de la commande du formulaire
$commande = filter_input(INPUT_POST, "btnSubmit");

//    Ajouter une nouvelle note
if ($commande == "Ajouter") {
  // Penser à valider
  $branche = filter_input(INPUT_POST, "branche");
  $date = filter_input(INPUT_POST, "date");
  $note = filter_input(INPUT_POST, "note");
  $remarque = filter_input(INPUT_POST, "remarque");

  if (createNote($branche, $date, $note, $remarque, coefficient($branche))) {
    $errorMsg = "La nouvelle note est ajoutée à la base";
  } else {
    $errorMsg = "Une erreur est survenue lors de l'ajout à la base";
  }
}
?>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Normes crud_php - Create</title>
    <link rel="stylesheet" type="text/css" href="./lib/crud.css">
</head>

<body>
    <h1>CREATE</h1>
    <nav>
        <?php include "./lib/nav.inc.php"; ?>
    </nav>
    <form action="#" method="POST">
        <table>
            <tr>
                <td colspan="4"><?= $errorMsg ?></td>
            </tr>
            <tr>
                <td>Branche : </td>
                <td><?php echo brancheToSelect($branche) ?></td>
                <td>Date : </td>
                <td><input type="date" name="date" value="<?= $date ?>"></td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td>Note : </td>
                <td><input type="text" name="note" value="<?= $note ?>"></td>
                <td>Remarque : </td>
                <td><input type="text" name="remarque" value="<?= $remarque ?>"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><input type="submit" name="btnSubmit" value="Ajouter"></td>
            </tr>
        </table>
        <?php
    echo arrayToHtmlTable(readNotes());
    ?>
    </form>
    <footer>2020 - PHP - Normes école informatique - CRUD - Prepare statements</footer>
</body>

</html>