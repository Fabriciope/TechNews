<?php

$minCSS = new MatthiasMullie\Minify\CSS();

$minCSS->add(__DIR__ . "./../../shared/css/styles.css");
$minCSS->add(__DIR__ . "./../../shared/css/search-articles.css");

$cssDir = scandir(__DIR__ . "./../../views/assets/css");

if (count($cssDir) > 2) {

    foreach ($cssDir as $css) {
        $cssFIle = __DIR__ . "./../../views/assets/css/{$css}";

        if (is_file($cssFIle) && pathinfo($cssFIle)['extension'] == "css") {
            $minCSS->add($cssFIle);
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
