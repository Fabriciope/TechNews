<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= theme("assets/style.css") ?>">
    <link rel="stylesheet" href="./css/home.css">

    <script src="https://kit.fontawesome.com/d5c56409b7.js" crossorigin="anonymous"></script>

    <title><?= $this->e($title, "ucfirst") ?></title>
</head>

<body>

    <div class="container_menu_active">
        <nav class="box_name">
        <nav class="nav_mobile_active">
                <button class="btn_menu_mobile_active">
                <i class="fa-solid fa-xmark"></i>
                </button>
                <ul class="ul_main_mobile_active">
                    <li><a href="<?=url("/")?>">Home</a></li>
                    <li><a href="<?=url("/artigos")?>">Artigos</a></li>
                    <li><a href="">Sobre</a></li>
                    <?php if(true): ?>
                        <li class="active_dropdown">
                        <a href="">Perfil <i class="fa-solid fa-angle-down"></i> </a>
                        <ul class="dropdown_menu_mobile_active">
                            <li><a href="">Perfil</a></li>
                            <li><a href="">Artigos já publicados</a></li>
                            <li><a href="">Artigos salvos</a></li>
                            <li><a href="">Adicionar novo artigo</a></li>
                        </ul>
                    </li>
                    <?php else: ?>
                        <li><a class="btn_active" href="<?=url("/entrar")?>">Entrar</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </nav>
    </div>

    <header>
        <div class="site_width center_header">
            <div class="box_logo">
                <a href="">
                    <h1>
                        <img src="<?= theme("assets/images/logo-tech.png") ?>" alt="">
                        <span>Tech</span>News
                    </h1>
                </a>
            </div>

            <nav class="header_nav">
                <button class="btn_menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <ul class="ul_main">
                    <li><a href="<?=url("/")?>">Home</a></li>
                    <li><a href="<?=url("/artigos")?>">Artigos</a></li>
                    <li><a href="">Sobre</a></li>
                    <?php if(false): ?>
                        <li>
                        <a href="">Perfil <i class="fa-solid fa-angle-down"></i> </a>
                        <ul class="dropdown_menu">
                            <li><a href="">Perfil</a></li>
                            <li><a href="">Artigos já publicados</a></li>
                            <li><a href="">Artigos salvos</a></li>
                            <li><a href="">Adicionar novo artigo</a></li>
                        </ul>
                    </li>
                    <?php else: ?>
                        <li><a class="btn_active" href="<?=url("/entrar")?>">Entrar</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <?= $this->section("content"); ?>
    </main>



    <footer>
        <div class="container_footer">
            <article>
                <h5>Sobre:</h5>
                <p>
                    asdasdasdads
                </p>
            </article>
            <article>
                <h5>Mais:</h5>
                <ul>
                    <ol>asdad</ol>
                    <ol>asdad</ol>
                    <ol>asdad</ol>
                </ul>
            </article>
            <article>
                <h5>Contato:</h5>
                <ul>
                    <ol>asdad</ol>
                    <ol>asdad</ol>
                    <ol>asdad</ol>
                </ul>
            </article>
            <article>
                <h5>Social:</h5>
                <ul>
                    <ol>asdad</ol>
                    <ol>asdad</ol>
                    <ol>asdad</ol>
                </ul>
            </article>
        </div>
    </footer>

    <script src="<?=theme("assets/scripts.js")?>"></script>

</body>

</html>