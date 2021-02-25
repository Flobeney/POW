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
$idNote = "";
$errorMsg = "Modifiez vos données et cliquez sur Enregistrer";


// Traitement de la commande du formulaire
$commande = filter_input(INPUT_POST, "btnSubmit");
if ($commande == "Modifier") {
  $idNote = filter_input(INPUT_POST, "idnote");
  // récupérer les données pour la note
  $result = readNote($idNote);
  if (is_array($result)) {
    $branche = $result[0]["branche"];
    $date = $result[0]["date"];
    $note = $result[0]["note"];
    $remarque = $result[0]["remarque"];
    $errorMsg = "Veuillez modifier les données de la note.";
  } else {
    $errorMsg = "Une erreur est survenue lors de la récupération des données";
  }
}

//    Ajouter une nouvelle note
if ($commande == "Enregistrer") {
  // @TODO : Penser à valider le contenu des champs
  $idNote = filter_input(INPUT_POST, "idNote");
  $branche = filter_input(INPUT_POST, "branche");
  $date = filter_input(INPUT_POST, "date");
  // $dateTime = DateTime::createFromFormat('d/m/Y', $dateEurope);
  // $date = $dateTime->format('Y-m-d');
  $note = filter_input(INPUT_POST, "note");
  $remarque = filter_input(INPUT_POST, "remarque");

  if (updateNote($idNote, $branche, $date, $note, $remarque)) {
    $errorMsg = "La note est modifiée dans la base";
  } else {
    $errorMsg = "Une erreur est survenue lors de le modification dans la base";
  }
}
?>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Normes crud_php - Update</title>
    <link rel="stylesheet" type="text/css" href="./lib/crud.css">
</head>

<body>
    <h1>UPDATE</h1>
    <nav>
        <?php include "./lib/nav.inc.php"; ?>
    </nav>
    <form action="#" method="POST">
        <table>
            <tr>
                <td>Veuillez choisir un idNote à modifier et cliquez sur Modifier</td>
                <td><input type="text" name="idnote" value="<?= $idNote ?>"></td>
                <td><input type="submit" name="btnSubmit" value="Modifier"></td>
            </tr>
        </table>
    </form>
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
                <td><input type="hidden" name="idNote" value="<?= $idNote ?>"></td>
                <td><input type="submit" name="btnSubmit" value="Enregistrer"></td>
            </tr>
        </table>

        <?php
    echo arrayToHtmlTable(readNotes());
    ?>
    </form>
    <footer>2020 - PHP - Normes école informatique - CRUD - Prepare statements</footer>
</body>

</html>