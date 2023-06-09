<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= theme("assets/style.css") ?>">

    <script src="https://kit.fontawesome.com/d5c56409b7.js" crossorigin="anonymous"></script>

    <title><?= $this->e($title, "ucfirst") ?></title>
</head>

<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
            <p class="ajax_load_title">Aguarde, carregando...</p>
    </div>
</div>

<body>

<div class="fixedMessage">
    <?= flash() ?>
</div>



<!-- CONTAINER MENU MOBILE -->
<div class="container_menu_active">
    <nav class="nav_mobile_active">
        <button class="btn_menu_mobile_active">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <ul class="ul_main_mobile_active">
            <li><a href="<?= url("/") ?>">Home</a></li>
            <li><a href="<?= url("/artigos") ?>">Artigos</a></li>
            <li><a href="<?=url('/sobre')?>">Sobre</a></li>
            <?php if (isLogged()) : ?>
                <li class="li_profile">
                    <span>Perfil <i class="fa-solid fa-angle-down"></i></span> 
                    <ul class="dropdown_menu_mobile_active">
                        <li><a href="<?=url("/perfil")?>">Perfil</a></li>
                        <li><a href="<?=url("/perfil/artigo/publicados")?>">Artigos publicados</a></li>
                        <li><a href="<?=url("/perfil/artigo/salvos")?>">Salvos para publicação</a></li>
                        <li><a href="<?=url("/perfil/artigo/novo")?>">Novo artigo</a></li>
                    </ul>
                </li>
            <?php else : ?>
                <li><a class="btn_active" href="<?= url("/entrar") ?>">Entrar</a></li>
            <?php endif; ?>
        </ul>

    </nav>
</div>

    <header class="header_default">
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
                    <li><a href="<?=url("/") ?>">Home</a></li>
                    <li><a href="<?=url("/artigos")?>">Artigos</a></li>
                    <li><a href="<?=url('/sobre')?>">Sobre</a></li>
                    <?php if (isLogged()) : ?>
                        <li>
                            <a href="<?=url("/perfil")?>">Perfil <i class="fa-solid fa-angle-down"></i> </a>
                            <ul class="dropdown_menu">
                                <li><a href="<?=url("/perfil")?>">Perfil</a></li>
                                <li><a href="<?=url("/perfil/artigo/publicados")?>">Artigos publicados</a></li>
                                <li><a href="<?=url("/perfil/artigo/salvos")?>">Salvos para publicação</a></li>
                                <li><a href="<?=url("/perfil/artigo/novo")?>">Novo artigo</a></li>
                            </ul>
                        </li>
                    <?php else : ?>
                        <li><a class="btn_active" href="<?= url("/entrar") ?>">Entrar</a></li>
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
                    Site de artigos de tecnologia
                </p>
            </article>
            <article>
                <h5>Mais:</h5>
                <ul>
                    <ol><a href="<?=url('/')?>">Home</a></ol>
                    <ol><a href="<?=url('/sobre')?>">Sobre</a></ol>
                </ul>
            </article>
            <article>
                <h5>Social:</h5>
                <ul>
                    <ol><a href="#">Instagram</a></ol>
                    <ol><a href="#">Facebook</a></ol>
                    <ol><a href="#">Linkedin</a></ol>
                </ul>
            </article>
        </div>
    </footer>

    <script src="<?= theme("assets/scripts.js") ?>"></script>

</body>

</html>