<?php
require "./lib/functions.inc.php";

if(filter_has_var(INPUT_POST, 'btnSubmit')){
    $filter = filter_input(INPUT_POST, 'recherche', FILTER_SANITIZE_STRING);
    //Récupérer les données
    $data = readDicoFilter($filter);
}else{
    //Récupérer les données
    $data = readDico();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dictionnaire</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
    <!-- Recherche -->
    <form action="#" method="POST">
        <table>
            <tr>
                <td>Choisissez un critère de recherche (branche, date) : </td>
                <td><input type="text" name="recherche"></td>
                <td><input type="submit" name="btnSubmit" value="Rechercher"></td>
            </tr>
        </table>
    </form>
    <!-- Données -->
    <table>
        <tr>
            <th>Mot</th>
            <th>Définition</th>
        </tr>
        <?php foreach ($data as $value) { ?>
            <tr>
                <td><?= $value['mot'];?></td>
                <td><?= $value['definition'];?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
