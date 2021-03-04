<?php
require './lib/functs.php';

//Nouvelle instance
$dico = new MyDico();
$ressources = array();

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
</head>
<body>
    <h1>Recherche</h1>
    <form action="#" method="POST">
        <label for="search_term">Terme :</label><br>
        <input type="text" name="search_term" value="<?= $dico->search_term;?>"><br>
        <input type="submit" name="search" value="Boolean mode" />
        <input type="submit" name="search" value="Natural mode" />
    </form>
    <?php

    if (count($ressources) == 0) {
        echo "<p><b>Ce mot n'existe pas dans ce dictionnaire</b></p>";
    } else {
        // Affiche le résultat de la requête
		echo "<p>Il y a " . count($ressources) . " résultats avec la recherche " . $dico->search_mode . "</p>";
		echo "\n<table border>";
		echo "\n<tr>";
		echo "\n    <th>ID</th>";
		echo "\n    <th>Contenu</th>";
		//Afficher le score si c'est en mode naturel
		if($dico->search_mode == 'Natural mode'){
			echo "\n    <th>Score</th>";
		}
		echo "</tr>";
        foreach ($ressources as $ressource) {
			echo "\n<tr>";
			echo "\n    <td>" . $ressource["id"] . "</td>";
			echo "\n    <td>" . $ressource["content"] . "</td>";
			//Afficher le score si c'est en mode naturel
			if($dico->search_mode == 'Natural mode'){
				echo "\n    <td>" . $ressource["score"] . "</td>";
			}
			echo "\n</tr>";
        }
        echo "\n</table>";
    }
    ?>
</body>
</html>