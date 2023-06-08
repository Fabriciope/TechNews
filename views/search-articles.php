<?php $this->layout("layouts::default", ["title" => $title]) ?>

<section class="site_width latest_news">
    <h2 class="title_section text_effect">voce pesquisou por: <?= text($search) ?></h2>
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
    <div class="container_article">
        <div class="container_article">
            <?php if ($articlesFound != null) : ?>
                <?php foreach ($articlesFound as $article) : ?>
                    <?= $this->insert("includes::article-list", ['article' => $article]) ?>
                <?php endforeach; ?>
            <?php else : ?>
                <h1>Nada encontrado</h1>
            <?php endif; ?>
        </div>
    </div>

    <div class="container_paginator">
        <nav class="paginator">
            <?php if (!$paginator->isFirst()) : ?>
                <a class="page_action" href="<?= url("/artigos/{$search}/1") ?>">Primeira</a>
                <a href="<?= url("/artigos/{$search}/" . $paginator->page() - 1) ?>">
                    <i class="fa-solid fa-angles-left"></i>
                </a>
            <?php endif; ?>

            <?= "<span> Página {$paginator->page()} de {$paginator->pageCount()} </span>" ?>

            <?php if (!$paginator->isLast()) : ?>
                <a href="<?= url("/artigos/{$search}/" . $paginator->page() + 1) ?>">
                    <i class="fa-solid fa-angles-right"></i>
                </a>
                <a class="page_action" href="<?= url("/artigos/{$search}/" . $paginator->pageCount()) ?>">Última</a>
            <?php endif; ?>
        </nav>
    </div>
</section>