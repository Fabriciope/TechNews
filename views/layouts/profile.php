<?php $this->layout("layouts::default", ["title" => $title]) ?>

<section class="site_width section_banner_profile">
    <div class="banner_profile" 
        style="background-image: url(<?=theme("assets/images/profile/banner-profile.jpg")?>);">
        <div class="box_banner_profile">
            <img src="<?=theme("assets/images/profile/img39 edit 2.1.jpg")?>" alt="">
            <div class="box_info_banner">
                <h5>Fabrício Pereira Alves</h5>
            </div>
        </div>
    </div>
</section>

<section class="site_width section_content_profile">
    <div class="container_profile">   
        <aside class="aside_profile">
            <ul>
                <li><a href="<?=url("/perfil")?>">Perfil</a></li>
                <li><a href="">Artigos publicados</a></li>
                <li><a href="<?=url("/perfil/artigos-salvos")?>">Salvo para publicação</a></li>
                <li><a href="<?=url("/perfil/novo-artigo")?>">Novo Artigo</a></li>
            </ul>
        </aside>

        <div class="content_profile">
            <?= $this->section("content") ?>
        </div>

    </div>
   
</section>