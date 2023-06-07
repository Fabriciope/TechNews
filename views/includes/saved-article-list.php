<div class="box_saved_article">
    <div class="box_info_saved_article">
        <div class="box_img_saved_article">
            <img src="<?= image($article->cover) ?>" alt="">
        </div>
        <div class="info_article_saved">
            <h4><?= text($article->title)?></h4>
            <p>Criado dia: <?= date_fmt($article->created_at) ?></p>
        </div>
    </div>
    <div class="box_actions_saved">
        <form action="<?= url('/perfil/artigo/publicar') ?>" method="POST">
            <button class="btn_action_saved publish" name="articleUri" value="<?= $article->uri ?>">Publicar</button>
        </form>
        <a class="btn_action_saved btn_yellow" href="<?= url("/perfil/artigo/editar/{$article->uri}") ?>">Editar</a>
        <form action="<?= url("perfil/artigo/deletar") ?>" method="POST">
            <!-- MOSTRAR UM POP-UP ANTES DE DELETAR -->
            <button class="btn_action_saved btn_red" name="articleUri" value="<?= $article->uri ?>">Deletar</button>
        </form>
    </div>
</div>