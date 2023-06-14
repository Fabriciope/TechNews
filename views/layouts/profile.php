<?php $this->layout("layouts::default", ['title' => $title]) ?>


<?= $this->insert('includes::user-banner', [
    'photo' => $userData->photo, 
    'banner' => $userData->banner,
    'name' => "{$userData->first_name} {$userData->last_name}"
]); ?>

<section class="site_width section_content_profile">
    <div class="container_profile">   
        <aside class="aside_profile">
            <ul>
                <li><a href="<?=url("/perfil")?>">Perfil</a></li>
                <li><a href="<?=url("/perfil/artigo/publicados")?>">Artigos publicados</a></li>
                <li><a href="<?=url("/perfil/artigo/salvos")?>">Salvo para publicação</a></li>
                <li><a href="<?=url("/perfil/artigo/novo")?>">Novo Artigo</a></li>
            </ul>
        </aside>

        <div class="content_profile">
            <?= $this->section("content") ?>
        </div>

    </div>
   
</section>