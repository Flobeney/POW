<!DOCTYPE html>
<?php
/*
 * 2020 - PHP - Normes école informatique - CRUD - Prepare statements
 * Réaliser un CRUD sur une table simple MySql.
 * Auteur : P. Bonvin - Ecole d'informatique
 */
require './lib/functions.inc.php';

// initialisation des variables du script (évite les erreurs notice)
$idNote = "";
$errorMsg = "Saisissez le numéro (idnote) de la note a supprimer.";

// Ce formulaire peut recevoir différentes commandes
// Ajouter, Modifier, Supprimer, Rechercher
$commande = filter_input(INPUT_POST, "btnSubmit");

// 3) Editer
//    Edite une note existante soit depuis le formulaire POST
//    soit depuis un lien GET
if ($commande == "Supprimer") {
  // Pas de formulaire POST, tente le GET
  $idNote = filter_input(INPUT_POST, "idNote");
  if ($idNote != null) {
    // Récupérer les champs du formulaire et changer le BtnSubmit
    if (deleteNote($idNote)) {
      $errorMsg = "La note $idNote a été supprimée";
    } else {
      $errorMsg = "Un problème est survenu lors de la suppression de la note $idNote";
    }
  }
}
?>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Normes crud_php</title>
    <link rel="stylesheet" type="text/css" href="./lib/crud.css">
</head>

<body>
    <h1>DELETE</h1>
    <nav>
        <?php include "./lib/nav.inc.php"; ?>
    </nav>
    <form action="#" method="POST">
        <table>
            <tr>
                <td colspan="3"><?= $errorMsg ?></td>
            </tr>
            <tr>
                <td>Supprimer la note : </td>
                <td><input type="text" name="idNote" value="<?= $idNote ?>"></td>
                <td><input type="submit" name="btnSubmit" value="Supprimer"></td>
            </tr>
        </table>
        <?php
    echo arrayToHtmlTable(readNotes());
    ?>
        <footer>2020 - PHP - Normes école informatique - CRUD - Prepare statements</footer>
</body>

</html>