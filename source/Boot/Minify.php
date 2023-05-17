<?php

$minCSS = new MatthiasMullie\Minify\CSS();

$minCSS->add(__DIR__ . "./../../shared/css/boot.css");
$minCSS->add(__DIR__ . "./../../shared/css/layout-default.css");

// $cssDir = array_map(function($nameFileOrFolder){
//     $fileOrDir = __DIR__ . "./../../views/assets/css/{$nameFileOrFolder}";
//     var_dump($fileOrDir);
//     if(is_dir($fileOrDir) && file_exists($fileOrDir)) $nameFileOrFolder;
// }, scandir(__DIR__ . "./../../views/assets/css"));

$cssDir = scandir(__DIR__ . "./../../views/assets/css");


if (count($cssDir) > 2) {

    foreach ($cssDir as $nameCssFileOrDir) {

        if($nameCssFileOrDir != "." && $nameCssFileOrDir != "..") {
            $cssFIleOrDIr = __DIR__ . "./../../views/assets/css/{$nameCssFileOrDir}";

            if (is_dir($cssFIleOrDIr) && file_exists($cssFIleOrDIr)) {
    
                $nameCssSubDir = $nameCssFileOrDir;
                $pathCssSubDir = $cssFIleOrDIr;
    
                $arrCssSubDir = scandir($pathCssSubDir);
    
                foreach ($arrCssSubDir as $subFile) {
                    $cssSubFile = __DIR__ . "./../../views/assets/css/{$nameCssSubDir}/{$subFile}";
    
                    if (is_file($cssSubFile) && pathinfo($cssSubFile)['extension'] == "css") {
                        $minCSS->add($cssSubFile);
                    }
                }
                continue;
            }
    
            $cssFIle = $cssFIleOrDIr;
    
            if (is_file($cssFIle) && pathinfo($cssFIle)['extension'] == "css") {
                $minCSS->add($cssFIle);
            }
        }
    }
}
$minCSS->minify(__DIR__ . "./../../views/assets/style.css");


$minJS = new MatthiasMullie\Minify\JS();

$minJS->add(__DIR__ . "./../../shared/scripts/menu.js");

$jsDir = scandir(__DIR__ . "./../../views/assets/scripts");
if (count($jsDir) > 2) {

    foreach ($jsDir as $js) {
        $jsFIle =  __DIR__ . "./../../views/assets/scripts/{$js}";


        if (is_file($jsFile) && pathinfo($jsFIle)['extension'] == "js") {
            $minJS->add($jsFIle);
        }
    }
}
$minJS->minify(__DIR__ . "./../../views/assets/scripts.js");
