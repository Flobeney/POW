<?php

//Découper le fichier en séparant avec les points
$file = explode('.', file_get_contents('file.txt'));
//SQL d'insertion dans la base
$sql = "INSERT INTO `ressources`(`content`) VALUES ";
//Ajouter chaque phrases
foreach ($file as $sentence) {
	//Échapper les ' et "
	$sql .= "('" . addslashes($sentence) . "'),";
}
//Enlever la dernière virgule
$sql = substr($sql, 0, strrpos($sql, ','));
//Ajouter le point-virgule
$sql .= ";";

echo $sql;
