<?php
session_start();
//Créer l'image
$img = imagecreatefromjpeg('img/wallhaven.jpg');

//Récupérer les variables
$size = isset($_SESSION['size']) ? $_SESSION['size'] : 50;
$left = isset($_SESSION['left']) ? $_SESSION['left'] : 50;
$top = isset($_SESSION['top']) ? $_SESSION['top'] : 50;

//Couleur du rectangle
$color = imagecolorallocate($img, 255, 255, 255);

//Dessiner le rectangle
imagerectangle(
    //Image sur laquelle dessiner
    $img, 
    //Coordonnées x,y du dessin
    $left, $top, 
    //Taille du dessin
    $size + $left, $size + $top, 
    //Couleur du dessin
    $color
);

//Afficher l'image
header("Content-type: image/jpeg");
imagejpeg($img);

?>