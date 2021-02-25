<?php
require("./lib/dico.inc.php");

// Traitement des champs du formulaire
if (isset($_REQUEST["search_term"])) {
    $search_term = $_REQUEST["search_term"];
    $search_type = "full";
} else if (isset($_REQUEST["word"])) {
    $search_term = $_REQUEST["word"];
    $search_type = "exactword";
} else {
    $search_term = "";
    $search_type = "";
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Dictionnaire Match - Against</title>
    <link href="./css/style.css" rel="stylesheet" media="screen">
</head>

<body>
<form action="#" method="post">
    <fieldset>
        <label for="input_search">Recherche : </label>
        <input type="text" name="search_term" id="input_search" value="<?= $search_term ?>">
        <input type="submit" value="Chercher">
    </fieldset>
</form>

<?php
// Nouvelle instance
$monDico = new MyDico();

$monDico->search_term = $search_term;
$monDico->search_type = $search_type;

$mesDefinitions = $monDico->getDefinitions();

if (Count($mesDefinitions) == 0) {
    echo "<p><b>Ce mot n'existe pas dans ce dictionnaire</b></p>";
} else {
    // Affiche le résultat de la requête
    echo "\n" . '<table id="definition_table">';
    echo "\n  <tr>\n    <th>Mot</th>\n    <th>définition</th>\n  </tr>";
    foreach ($mesDefinitions as $entreeDico) {
        echo "\n  <tr>";
        echo "\n    <td>" . $entreeDico["mot"] . "</td>";
        echo "\n    <td>" . $monDico->definitionToTextWithLink($entreeDico["definition"]) . "</td>";
        echo "\n  </tr>";
    }
    echo "\n</table>";
}
?>
<footer>
    <p>
        PBN Aout 2020
    </p>
</footer>
</body>