<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($title, 'mb_strtoupper') ?></title>

    <style>
        body {
            box-sizing: border-box;
            font-family: Helvetica, sans-serif;
        }
        .content {
            font-size: 17px;
            margin-bottom: 30px;
            padding-bottom: 5px;
        }
        .content p {
            margin: 20px 0;
        }
        .image {
            width: 95%;
            margin: 5px auto 20px auto;
        }
    </style>

</head>
<body>
    <main>
        <div class="content">
            <?= $this->section('content') ?>
        </div>
    </main>
</body>
</html>