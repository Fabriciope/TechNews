<?php $this->layout("layouts::default", ["title" => $title]) ?>

<?= $this->insert('includes::user-banner', []) ?>

<section class="site_width section_content_profile">
    <div class="container_profile">   
        <aside class="aside_profile">
            <ul>
                <li><a href="<?=url("/perfil")?>">Perfil</a></li>
                <li><a href="<?=url("/perfil/artigos-publicados")?>">Artigos publicados</a></li>
                <li><a href="<?=url("/perfil/artigos-salvos")?>">Salvo para publicação</a></li>
                <li><a href="<?=url("/perfil/novo-artigo")?>">Novo Artigo</a></li>
            </ul>
        </aside>

        <div class="content_profile">
            <?= $this->section("content") ?>
        </div>

    </div>
   
</section>