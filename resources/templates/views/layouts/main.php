<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?=css('bootstrap/boot') ?>">
    <link rel="stylesheet" href="<?=css('bootstrap/message')?>">

    <link rel="stylesheet" href="<?=css('layouts/main')?>">

    <?= $this->section('styles') ?>

    <script src="https://kit.fontawesome.com/d5c56409b7.js" crossorigin="anonymous"></script>

    <title><?= $this->e($title) ?></title>
</head>

<body>

    <?= $this->fetch('layouts::components/header') ?>

    <main>
        <?= $this->section("content"); ?>
    </main>

    <?= $this->fetch('layouts::components/footer') ?>

    <script src="<?=script('menu')?>"></script>
    <?= $this->section('scripts') ?>
</body>
</html>
