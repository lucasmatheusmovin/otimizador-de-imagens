<?php

if(isset($_GET['action']) && $_GET['action'] == 'listar'){
    listar();
}


if(isset($_GET['action']) && $_GET['action'] == 'otimizarUnica'){
    otimizarUnica($_GET['file']);
}
?>

<br>
<a href="index.php?action=listar">Listar Imagens</a>

<?php

function otimizarTodas(){
    //1000000 bytes = 1MB
    $tamanhomaximo = 1000000;
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
    } 
function listar(){
    //1000000 bytes = 1MB
    $tamanhomaximo = 2000000; //2mb
    $path = "imagens/";
    $files = scandir($path);
    $quantidade = 0;
    $espaco = 0;
        if ($files !== false) {
            foreach($files as $f) {
                if ($f == '..' || $f == '.') continue;
                    if (filesize($path. $f) > $tamanhomaximo){
                     echo "Arquivo: ". $path.$f . " Tamanho: " . filesize($path . $f) ." <a href='index.php?action=otimizarUnica&file=".$path.$f."'>Otimizar esta imagem</a>" ."<br>";
                     $quantidade ++;
                     $espaco = $espaco + filesize($path . $f);
                }
            }
            echo "<br> Tamanho ocupado por " . $quantidade . " imagens: " . $espaco . " bytes";
        }
    
}   

function otimizarUnica(string $file){

    $path = $file;
    $image = imagecreatefromjpeg($path);
    imagejpeg($image, $path, 50);
    imgResize($file);

    return listar();

    
    }
    
    function imgResize($path) {

        $x = getimagesize($path);            
        $width  = $x['0'];
        $height = $x['1'];

        $rs_width  = $width / 2;//resize to half of the original width.
        $rs_height = $height / 2;//resize to half of the original height.

        switch ($x['mime']) {
           case "image/gif":
              $img = imagecreatefromgif($path);
              break;
           case "image/jpg":
           case "image/jpeg":
              $img = imagecreatefromjpeg($path);
              break;
           case "image/png":
              $img = imagecreatefrompng($path);
              break;
        }

        $img_base = imagecreatetruecolor($rs_width, $rs_height);
        imagecopyresized($img_base, $img, 0, 0, 0, 0, $rs_width, $rs_height, $width, $height);

        $path_info = pathinfo($path);    
        switch ($path_info['extension']) {
           case "gif":
              imagegif($img_base, $path);  
              break;
         case "jpg":
         case "jpeg":
              imagejpeg($img_base, $path);
              break;
           case "png":
              imagepng($img_base, $path);  
              break;
        }

     }




?>

