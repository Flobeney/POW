<?php
//Créer l'image
$img = imagecreatetruecolor(100, 100);

//Couleur du rond
$colRound = imagecolorallocate($img, 255, 255, 255);

//Dessiner le rond
imagefilledellipse(
    //Image sur laquelle dessiner
    $img, 
    //Coordonnées x,y du dessin
    50, 50, 
    //Taille du dessin
    50, 50, 
    //Couleur du dessin
    $colRound
);

//Afficher l'image
header("Content-type: image/png");
imagepng($img);

?>