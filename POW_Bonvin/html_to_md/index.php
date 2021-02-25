<?php
require 'vendor/autoload.php';
use League\HTMLToMarkdown\HtmlConverter;

$converter = new HtmlConverter();

if(filter_has_var(INPUT_POST, 'submit')){
    $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);
    $html = file_get_contents($url);
    $markdown = $converter->convert($html);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>HTML to MD</title>
</head>
<body>
    <form action="#" method="POST">
        <label for="url">URL :</label><br>
        <input type="text" name="url" ><br>
        <input type="submit" name="submit" value="Submit">
    </form> 
    <?= $markdown;?>
</body>
</html>