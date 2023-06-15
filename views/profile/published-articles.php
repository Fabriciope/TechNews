<?php $this->layout('layouts::profile', ['title' => $title, 'userData' => $userData]) ?>

<?php if (is_array($publishedArticles)) : ?>
    <div class="container_published_articles">
        <?php foreach ($publishedArticles as $article) : ?>
            <?= $this->insert('includes::published-article-list', ['article' => $article]) ?>
        <?php endforeach; ?>

    </div>
    <div class="container_paginator">
        <nav class="paginator">
            <?= $this->insert('includes::paginator', ['paginator' => $paginator]) ?>
        </nav>
    </div>
<?php else : ?>
    <h3 class="empty">Você não possui nenhum artigo publicado. <a href="<?= url('/perfil/artigo/novo') ?>">Artigos salvos</a></h3>
<?php endif; ?>