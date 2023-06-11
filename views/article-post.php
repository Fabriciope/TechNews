<?php $this->layout('layouts::default', ['title' => $title]) ?>

<section class="site_width section_article_post">
    <article class="container_article_post">
        <?php if ($userArticle) : ?>
            <div class="box_btn_action_user">
                <a class="btn_action_user btn_yellow" href="<?= url("/perfil/artigo/editar/{$article->uri}") ?>">Editar</a>
                <form action="<?= url("perfil/artigo/deletar") ?>" method="POST">
                    <!-- MOSTRAR UM POP-UP ANTES DE DELETAR -->
                    <button class="btn_action_user btn_red" name="articleUri" value="<?= $article->uri ?>">Deletar</button>
                </form>
            </div>
        <?php endif; ?>
        <header class="header_article_post">
            <h1 class="text_effect"><?= $article->title ?></h1>
            <div class="box_info_article_post">
                <div class="box_info_left">
                    <img class="photo_author_article_post" src="<?= image($article->author('photo')) ?>" alt="">
                    <p class="name_author_article">Por:
                        <a href="<?= url("/usuario/{$article->author('id')}") ?>"><?= text($article->author('first_name')) . ' ' .  $article->author('last_name') ?></a>
                    </p>
                </div>
                <p class="date_article"><?= date_fmt($article->published_at) ?></p>
            </div>
        </header>

        <div class="container_article_content">
            <h2><?= $article->subtitle ?></h2>

            <?php if ($article->video !== null) : ?>
                <div class="box_video">
                    <iframe src="<?= $article->video ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"></iframe>
                </div>
            <?php endif; ?>
            <?php foreach ($paragraphs as $paragraph) : ?>
                <?= is_null($paragraph->title) ?  '' : '<h3>' . $paragraph->title . '</h3>' ?>
                <?= '<p>' . $paragraph->paragraph . '</p>' ?>
            <?php endforeach; ?>
        </div>

    </article>

    <!-- TODO: melhorar a responsividade dos artigos relacionados -->
    <?php if (!empty($relatedArticles)) : ?>
        <section class="section_related_articles">
            <h4>Artigos relacionados</h4>
            <div class="box_related_articles">
                <?php foreach ($relatedArticles as $article) : ?>
                    <?= $this->insert('includes::article-list', ['article' => $article]) ?>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- TODO: fazer a verificação se existe comentários naquele artigo -->
    <section class="section_comments">
        <h4>Comentários</h4>
        <div class="container_comments">
            <?php for ($i = 0; $i <= 3; $i++) : ?>
                <?= $this->insert('includes::comment-list', []) ?>
            <?php endfor; ?>
        </div>
    </section>

    <?php if (true) : ?>
        <section class="section_new_comment">
            <h4>Adicionar um comentário</h4>

            <div class="box_new_comment">
                <form class="formAjax" action="">

                    <!-- TODO: repensar se vai recarregar a página se o comentário for registrado ou se o usuário terá que recarregar página será apresentado uma mensagem de sucesso -->
                    <div class="ajax_response">
                        <?= flash() ?>
                    </div>

                    <?= csrf_input() ?>
                    <textarea name="" id="" rows="6" placeholder="Digite oque você deseja comentar..."></textarea>
                    <button class="gb_btn">Comentar</button>
                </form>
            </div>
        </section>
    <?php endif; ?>
</section>