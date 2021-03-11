<?php
session_start();
//Créer l'image
$img = imagecreatefromjpeg('img/wallhaven.jpg');

//Récupérer les variables
$size = isset($_SESSION['size']) ? $_SESSION['size'] : 50;
$left = isset($_SESSION['left']) ? $_SESSION['left'] : 50;
$top = isset($_SESSION['top']) ? $_SESSION['top'] : 50;

//Crop l'image
$crop = imagecrop(
    $img,
    array(
        'x' => $left, 
        'y' => $top, 
        'width' => $size, 
        'height' => $size
    )
);

//Afficher l'image
header("Content-type: image/jpeg");
imagejpeg($crop);

?>