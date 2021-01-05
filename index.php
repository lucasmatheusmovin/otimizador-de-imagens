<?php

//3000000 bytes = 3MB
$tamanhomaximo = 3000000;
$path = "imagens/";
$files = scandir('imagens/');
    if ($files !== false) {
        foreach($files as $f) {
            if ($f == '..' || $f == '.') continue;
            if (filesize($path. $f) > $tamanhomaximo){
                echo filesize($path . $f) . "<br>";
                $image = imagecreatefromjpeg($path . $f);
                imagejpeg($image, $path . $f, 50);
            }
        }
    }

?>

