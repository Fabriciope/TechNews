<?php $this->layout("layouts::default", ["title" => $title]) ?>

<section class="site_width latest_news">
    <h2 class="title_section text_effect">voce pesquisou por: <?=text($search)?></h2>
    <form action="<?=url('/artigos/pesquisar')?>" method="POST">
        <label id="search_article" class="box_search_article page_articles">
            <input type="text" name="search" id="search_article" placeholder="pesquise por algo ...">
            <button><i class="fa-solid fa-magnifying-glass"></i></button>
        </label>
    </form>
    <div class="container_article">
        <div class="container_article">
            <?php foreach ($articlesFound as $article) : ?>
                <?= $this->insert("includes::article-list", ['article' => $article]) ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>