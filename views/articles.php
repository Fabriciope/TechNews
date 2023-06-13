<?php $this->layout("layouts::default", ["title" => $title]) ?>

<!-- MELHORES ARTIGOS -->

<section class="site_width" style="margin-top: 2rem;">
    <h2 class="title_section text_effect">Artigos mais visualizados</h2>
    <div class="best">

        <!-- TODO: adicionar um link para redirecionar para o artigo -->
        <div class="container_best">
            <div class="container_article_left">
                <article class="article_left_best effect_article_best">
                    <img src="<?= image($relevantArticles[0]->cover) ?>" alt="">
                    <div class="title_article_best title_article_left">
                        <h4><?= str_limit_chars($relevantArticles[0]->title, 130) ?></h4>
                    </div>
                </article>
            </div>

            <div class="container_articles_right">
                <?php foreach (array_slice($relevantArticles, 1) as $article) : ?>
                    <article class="effect_article_best">
                        <img src="<?= image($article->cover) ?>" alt="">
                        <div class="title_article_best">
                            <h4><?= str_limit_chars($article->title, 100) ?></h4>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>



<!-- CAIXA DE PESQUISA E ULTIMAS NOTÍCIAS -->
<section class="site_width latest_news">
    <h2 class="title_section text_effect">Veja os últimos artigos pulicados</h2>
    <form class="formAjax" action="<?= url('/artigos/buscar') ?>" method="POST">

        <div class="ajax_response">
            <?= flash() ?>
        </div>

        <?= csrf_input() ?>

        <label id="search_article" class="box_search_article page_articles">
            <input type="text" name="search" id="search_article" placeholder="pesquise por algo ...">
            <button><i class="fa-solid fa-magnifying-glass"></i></button>
        </label>
    </form>
    <div class="container_article">
        <div class="container_article">
            <?php foreach ($articles as $article) : ?>
                <?= $this->insert("includes::article-list", ['article' => $article]) ?>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="container_paginator">
        <nav class="paginator">
            <?= $this->insert('includes::paginator', ['paginator' => $paginator, 'uri' => $uri]) ?>
        </nav>
    </div>
</section>