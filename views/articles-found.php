<?php $this->layout("layouts::default", ["title" => $title]) ?>

<section class="site_width latest_news">
    <h2 class="title_section text_effect"><?= $search ? 'voce pesquisou por: ' . text($search) : text($category) ?></h2>
    <form class="formAjax" action="<?= url('/artigos/buscar') ?>" method="POST">

        <div class="ajax_response">
            <?= flash() ?>
        </div>

        <?= csrf_input() ?>

        <label id="search_article" class="box_search_article page_articles">
            <input type="text" name="search" id="search_article" value="<?= text($search) ?>" placeholder="pesquise por algo ...">
            <button><i class="fa-solid fa-magnifying-glass"></i></button>
        </label>
    </form>
    <div>
        <?php if ($articlesFound != null) : ?>
            <div class="container_article">
                <?php foreach ($articlesFound as $article) : ?>
                    <?= $this->insert("includes::article-list", ['article' => $article]) ?>
                <?php endforeach; ?>
            </div>
            <div class="container_paginator">
                <nav class="paginator">
                    <?= $this->insert('includes::paginator', ['paginator' => $paginator]) ?>
                </nav>
            </div>
        <?php else : ?>
            <h3 class="empty">Nenhum artigo encontrado para a sua pesquisa.
            </h3>
        <?php endif; ?>
    </div>


</section>