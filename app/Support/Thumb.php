<?php

// namespace App\Support;

// use CoffeeCode\Cropper\Cropper;

// class Thumb 
// {
//     private $cropper;
//     private $uploads;

//     public function __construct()
//     {
//         $this->cropper = new Cropper(__DIR__ . "./../.." . CONF_IMAGE_CACHE, CONF_IMAGE_QUALITY['jpg'], CONF_IMAGE_QUALITY['png']);
//         $this->uploads = CONF_UPLOAD_DIR;
//     }

//     public function make(string $image, int $width, int $height = null): string
//     {
//         $pathImg = $this->cropper->make(__DIR__ . "./../.." . $image, $width, $height);


//         $startSavePath = strpos($pathImg, CONF_IMAGE_CACHE);
//         return mb_substr($pathImg, $startSavePath);
//     }

//     public function flush(?string $image = null): void
//     {
//         if($image) {
//             $this->cropper->flush($image);
//             return;
//         }
//         $this->cropper->flush();
//     }

//     public function cropper(): Cropper
//     {
//         return $this->cropper;
//     }
// }