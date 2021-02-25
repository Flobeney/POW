<?php
require './lib/functs.php';

//Nouvelle instance
$dico = new MyDico();
$ressources = array();

//Add
if(filter_has_var(INPUT_POST, 'add')){
    //Récupérer les valeurs
    $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);

    //Ajout
    $dico->addRessource($url);
}

//Recherche
if(filter_has_var(INPUT_POST, 'search')){
    //Récupérer les valeurs
    $dico->search_term = filter_input(INPUT_POST, 'search_term', FILTER_SANITIZE_STRING);
    $dico->search_mode = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_STRING);

    //Recherche
    $ressources = $dico->search();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Google</title>
    <link href="./css/style.css" rel="stylesheet" media="screen">
</head>
<body>
    <h1>Ajouter une ressource</h1>
    <form action="#" method="POST">
        <label for="url">URL :</label><br>
        <input type="text" name="url" ><br>
        <input type="submit" name="add" value="Ajouter">
    </form>
    <hr>
    <h1>Recherche</h1>
    <form action="#" method="POST">
        <label for="search_term">Terme :</label><br>
        <input type="text" name="search_term" ><br>
        <input type="submit" name="search" value="Boolean mode" />
        <input type="submit" name="search" value="Natural mode" />
        <input type="submit" name="search" value="Expansion mode" />
    </form>
    <?php
    //Formatter de md
    $formatter = new Parsedown();

    if (count($ressources) == 0) {
        echo "<p><b>Ce mot n'existe pas dans ce dictionnaire</b></p>";
    } else {
        // Affiche le résultat de la requête
        echo "\n" . '<table id="definition_table">';
        echo "\n  <tr>\n    <th>URL</th>\n    <th>Contenu</th>\n  </tr>";
        foreach ($ressources as $ressource) {
            echo "\n  <tr>";
            echo "\n    <td><a href=\"" . $ressource["url"] ."\">" . $ressource["url"] . "</a></td>";
            echo "\n    <td><pre>" . $formatter->text($ressource["content_md"]) . "</pre></td>";
            echo "\n  </tr>";
        }
        echo "\n</table>";
    }
    ?>
</body>
</html>