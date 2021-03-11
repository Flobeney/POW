<?php
session_start();

define('STEP', 5);

//Récupérer le redimensionnement à faire
$resize = filter_input(INPUT_POST, 'resize', FILTER_SANITIZE_STRING);
//Récupérer le déplacement à faire
$move = filter_input(INPUT_POST, 'move', FILTER_SANITIZE_STRING);

//Redimensionnement
switch ($resize) {
    case 'Enlarge':
        $_SESSION['size'] += STEP;
        break;

    case 'Shrink':
        $_SESSION['size'] -= STEP;
        break;
    
    default:
        # code...
        break;
}

//Déplacement
switch ($move) {
    case 'Left':
        $_SESSION['left'] -= STEP;
        break;

    case 'Right':
        $_SESSION['left'] += STEP;
        break;
        
    case 'Top':
        $_SESSION['top'] -= STEP;
        break;

    case 'Bottom':
        $_SESSION['top'] += STEP;
        break;
    
    default:
        # code...
        break;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Resize image</title>
</head>
<body>
    <table>
        <tr>
            <th>
                Formulaire
            </th>
            <th>
                Image originale
            </th>
            <th>
                Image crop
            </th>
        </tr>
        <tr>
            <td>
                <form action="#" method="post">
                    <!-- Déplacement gauche droite -->
                    <div>
                        <input type="submit" name="move" value="Left">
                        <input type="submit" name="move" value="Right">
                    </div>
                    <!-- Déplacement haut bas -->
                    <div>
                        <input type="submit" name="move" value="Top">
                        <input type="submit" name="move" value="Bottom">
                    </div>
                    <!-- Agrandir rapetissir -->
                    <div>
                        <input type="submit" name="resize" value="Enlarge">
                        <input type="submit" name="resize" value="Shrink">
                    </div>
                </form>
            </td>
            <td>
                <img src="select_resize.php">
            </td>
            <td>
                <img src="crop.php">
            </td>
        <tr>
    </table>
</body>
</html>
