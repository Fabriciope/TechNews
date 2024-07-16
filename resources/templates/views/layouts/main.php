<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?=$this->e($title)?></title>
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <?= $this->fetch('layouts::components/header') ?>

        <?= $this->section('content') ?>

        <?= $this->fetch('layouts::components/footer') ?>

        <?= $this->section('scripts') ?>
        <?= $this->section('styles') ?>
    </body>
</html>
