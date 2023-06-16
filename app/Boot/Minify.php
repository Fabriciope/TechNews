<?php

$minCSS = new MatthiasMullie\Minify\CSS();

$minCSS->add(__DIR__ . './../../shared/css/boot.css');
$minCSS->add(__DIR__ . './../../shared/css/message.css');

$cssDir = scandir(__DIR__ . './../../views/assets/css');

if (count($cssDir) > 2) {

    foreach ($cssDir as $nameCssFileOrDir) {

        if($nameCssFileOrDir != '.' && $nameCssFileOrDir != '..') {
            $cssFIleOrDIr = __DIR__ . "./../../views/assets/css/{$nameCssFileOrDir}";

            if (is_dir($cssFIleOrDIr) && file_exists($cssFIleOrDIr)) {
    
                $nameSubDir = $nameCssFileOrDir;
                $pathSubDir = $cssFIleOrDIr;
    
                $arrSubDir = scandir($pathSubDir);
    
                foreach ($arrSubDir as $subFile) {
                    $SubFile = __DIR__ . "./../../views/assets/css/{$nameSubDir}/{$subFile}";
    
                    if (is_file($SubFile) && pathinfo($SubFile)['extension'] == 'css') {
                        $minCSS->add($SubFile);
                    }
                }
                continue;
            }
    
            $cssFIle = $cssFIleOrDIr;
    
            if (is_file($cssFIle) && pathinfo($cssFIle)['extension'] == 'css') {
                $minCSS->add($cssFIle);
            }
        }
    }
}

$minCSS->minify(__DIR__ . './../../views/assets/style.css');


$minJS = new MatthiasMullie\Minify\JS();

$minJS->add(__DIR__ . './../../shared/scripts/ajaxForm.js');

$jsDir = scandir(__DIR__ . './../../views/assets/scripts');
if (count($jsDir) > 2) {
    foreach ($jsDir as $js) {
        $jsFile =  __DIR__ . "./../../views/assets/scripts/{$js}";

        if (is_file($jsFile) && pathinfo($jsFile)['extension'] == 'js') {
            $minJS->add($jsFile);
        }
    }
}
$minJS->minify(__DIR__ . './../../views/assets/scripts.js');
