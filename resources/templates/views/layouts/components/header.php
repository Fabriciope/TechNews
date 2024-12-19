<!-- CONTAINER MENU MOBILE -->
<div class="container_menu_active">
    <nav class="nav_mobile_active">
        <button class="btn_menu_mobile_active">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <ul class="ul_main_mobile_active">
            <li><a href="<?php //url("/") ?>">Home</a></li>
            <li><a href="<?php //url("/artigos") ?>">Artigos</a></li>
            <li><a href="<?php //url('/sobre')?>">Sobre</a></li>
        </ul>

    </nav>
</div>

<header class="header_default">
    <div class="site_width center_header">
        <div class="box_logo">
            <a href="">
                <h1>
                    <img src="<?= image("logo-tech.png") ?>" alt="">
                    <span>Tech</span>News
                </h1>
            </a>
        </div>

        <nav class="header_nav">
            <button class="btn_menu">
                <i class="fa-solid fa-bars"></i>
            </button>
            <ul class="ul_main">
                <li><a href="<?php //url("/") ?>">Home</a></li>
                <li><a href="<?php //url("/artigos")?>">Artigos</a></li>
                <li><a href="<?php //url('/sobre')?>">Sobre</a></li>
            </ul>
        </nav>
    </div>
</header>
