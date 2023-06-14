<?php $this->layout('layouts::default', ['title' => $title]) ?>

<section class="site_width section_article_post">
    <article class="container_article_post">
        <?php if ($userArticle) : ?>
            <div class="box_btn_action_user">
                <a class="btn_action_user btn_yellow" href="<?= url("/perfil/artigo/editar/{$articleData->uri}") ?>">Editar</a>
                <form action="<?= url("perfil/artigo/deletar") ?>" method="POST">
                    <!-- MOSTRAR UM POP-UP ANTES DE DELETAR -->
                    <button class="btn_action_user btn_red" name="articleUri" value="<?= $articleData->uri ?>">Deletar</button>
                </form>
            </div>
        <?php endif; ?>
        <header class="header_article_post">
            <h1 class="text_effect"><?= $articleData->title ?></h1>
            <div class="box_info_article_post">
                <div class="box_info_left">
                    <img class="photo_author_article_post" src="<?= image($articleData->author('photo')) ?>" alt="">
                    <p class="name_author_article">Por:
                        <a href="<?= url("/usuario/{$articleData->author('id')}") ?>"><?= text($articleData->author('first_name')) . ' ' .  $articleData->author('last_name') ?></a>
                    </p>
                </div>
                <p class="date_article"><?= date_fmt($articleData->published_at) ?></p>
            </div>
        </header>

        <div class="container_article_content">
            <h2><?= $articleData->subtitle ?></h2>

            <?php if ($articleData->video !== null) : ?>
                <div class="box_video">
                    <iframe src="<?= $articleData->video ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"></iframe>
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

    <?php if ($comments) : ?>
        <section class="section_comments">
            <h4>Comentários:</h4>
            <div class="container_comments">
                <?php foreach ($comments as $comment) : ?>
                    <div class="box_comment_info_user">
                        <div class="box_info_user">
                            <div class="box_info">
                                <img src="<?= empty($comment->user('photo')) ? theme('/assets/images/perfil.jpg') : image($comment->user('photo')) ?>" alt="">
                                <p><?= "{$comment->user('first_name')} {$comment->user('last_name')}" ?></p>
                            </div>
                            <?php if ($comment->userComment()) : ?>
                                <form action="<?= url("artigo/deletar-comentario") ?>" method="POST">
                                    <button class="btn_action_user btn_red" name="commentId" value="<?= $comment->id ?>">Deletar comentário</button>
                                </form>
                            <?php endif; ?>

                        </div>
                        <div class="box_comment">
                            <h5>Comentário:</h5>
                            <p><?= $comment->comment ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="container_paginator">
                    <nav class="paginator comments">
                        <?= $this->insert('includes::paginator', ['paginator' => $commentPagination]) ?>
                    </nav>
                </div>
            </div>
        </section>
    <?php endif; ?>


    <section class="section_new_comment">
        <h4>Adicionar um comentário</h4>

        <div class="box_new_comment">
            <form class="formAjax" action="<?= url('/artigo/novo-comentario') ?>" method="POST">
                <div class="ajax_response">
                    <?= flash() ?>
                </div>
                <?= csrf_input() ?>

                <input type="hidden" name="articleId" value="<?= $articleData->id ?>">

                <textarea name="comment" id="" rows="6" placeholder="Digite oque você deseja comentar..."></textarea>
                <button type="submit" class="gb_btn">Comentar</button>
            </form>
        </div>
    </section>
</section>